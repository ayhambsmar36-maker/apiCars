<?php

namespace App\Http\Controllers;

use App\helper\Api;
use App\Http\Requests\CarForm;
use App\Http\Resources\CarResource;
use App\Models\Car;
use App\Models\Image;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::orderBy('created_at', 'desc')->paginate(10);
        if ($cars->isEmpty()) {
            return Api::responseApi('200', 'no cars vailable', []);

        }

        return Api::responseApi(200, 'cars retireved successfully', CarResource::collection($cars->load('images')));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarForm $request)
    {
        try {
            $car = Api::createCar($request);
        } catch (HttpResponseException $e) {
            return Api::responseApi('500', 'database error : '.($e->getResponse()->getContent()), []);
        }

        if ($request->hasFile('images')) {
            foreach ($request->images as $image) {
                $url = $image->store("images/{$car->id}", 'public');

                Image::create([
                    'url' => $url,
                    'car_id' => $car->id,
                ]);
            }

        } else {
            $car->delete();

            return Api::responseApi('400', 'no photo valid or phoo loaded', []);
        }

        return Api::responseApi(201, 'success create new car post', new CarResource($car->load('images')));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $car = Car::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return Api::responseApi(409, $e->getMessage(), []);

        }

        return Api::responseApi(200, 'retireved specified car successfully', new CarResource($car));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CarForm $request, string $id)
    {
        $car = Car::find($id);
        if (! $car) {
            return Api::responseApi(409, "no car found with id equal $id ", []);
        }
        $car->update($request->validated());
        if ($request->hasFile('images')) {
            foreach ($request->images as $image) {

                $image_id = $image->input('image_id');
                if ($image_id) {
                    $imageCar = $car->images->where('id', $image_id)->first();
                    if ($imageCar) {
                        Storage::delete($imageCar->url);
                        $url = $image->store("images/{$car->id}", 'public');
                        $imageCar->update(['url' => $url]);
                    }

                } else {
                    $url = $image->store("images/{$car->id}", 'public');
                    Image::create(['url' => $url, 'car_id' => $car->id]);
                }

            }

        }

        return Api::responseApi(200, 'update car is successfully ', new CarResource($car));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $car = Car::find($id);
        if (! $car) {
            return Api::responseApi(404, "no car found with id equal $id ", []);
        }
        foreach ($car->images as $image) {
            Storage::delete($image->url);
            $image->delete();
        } 
        $car->delete();

        return Api::responseApi(200, 'delete the specified car is successfully', []);
    }
}

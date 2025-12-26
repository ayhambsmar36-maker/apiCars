<?php

namespace App\Http\Controllers\Cars;

use App\helper\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\CarResource;
use App\Models\Brand;
use App\Models\Car;
use App\Models\Favorite;
use App\Models\Fuel;
use App\Models\Trans;
use Illuminate\Support\Facades\Auth;

class CarManagmentController extends Controller
{
    public function showCar_by_brand(string $brand)
    {

        $brand = Brand::where('name', $brand)->first();

        if (! $brand) {
            return Api::responseApi(400, 'brand of car not found', []);
        }
        $cars = $brand->cars;

        return Api::responseApi(200, 'retirved cars successfully', CarResource::collection($cars));
    }

    public function showCar_by_fuel(string $fuel)
    {
        $fuel = Fuel::where('name', $fuel)->first();
        if (! $fuel) {
            return Api::responseApi(400, 'type fuel of car not found', []);
        }
        $cars = $fuel->cars;

        return Api::responseApi(200, 'retirved cars successfully', CarResource::collection($cars));

    }

    public function showCar_by_trans(string $trans)
    {
        $trans = Trans::where('name', $trans)->first();
        if (! $trans) {
            return Api::responseApi(400, 'type transmission of car not found', []);
        }
        $cars = $trans->cars;

        return Api::responseApi(200, 'retirved cars successfully', CarResource::collection($cars));

    }
    public function favorite(string $car){
        $car = Car::where('id', $car)->first();
        if(!$car){
            return Api::responseApi(400,"car not found with id = $car", []);
        }
        if(!Auth::user()){
            return Api::responseApi(401,"login before ", []);
        }
        $user= Auth::user();
       $user->favoriteCars()->syncWithoutDetaching([$car->id]);
        return Api::responseApi(201,"Add new favorite car to ".  $user->name, new CarResource($car));

    }
    public function favorites(){
        if(!Auth::user()){
            return Api::responseApi(401,"login before ", []);
        }
        $user=Auth::user();
        $cars=$user->favoriteCars;
        return Api::responseApi(200,"retireved cars favorite successfully for user". Auth::user()->name, $cars);
       
    }
}

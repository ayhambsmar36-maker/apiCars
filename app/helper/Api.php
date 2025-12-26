<?php

namespace App\helper;
use App\Models\Car;
use App\Models\Brand;
use App\Models\Fuel;
use App\Models\Trans;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class Api
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public static function responseApi($code = 200, $msg = "", $data = []){
        return response()->json([
            "code"=> $code,
            "msg"=> $msg,
            "data"=> $data

        ],$code);
    }
    public static function createCar(Request $request){
       $fuel_id=Fuel::whereRaw("LOWER(type)=?",[strtolower($request->fuel)])->first();
       $brand_id=Brand::whereRaw("LOWER(name)=?",[strtolower($request->brand)])->first();
       if(!$brand_id){
        $brand_id=new Brand();
        $brand_id->name=$request->brand;
        $brand_id->save();
       }
       $trans_id=Trans::whereRaw("LOWER(type)=?",[strtolower($request->transmission)])->first();
      
if (!$fuel_id) {
     
    throw new HttpResponseException(Api::responseApi(400, "Fuel type not found", []));
}
if (!$trans_id) {
    throw new HttpResponseException(Api::responseApi(400, "transmission  type not found", []));
}

        $car=Car::create([
            'name'=> $request->name,
            'description'=>$request->description,
            "price"=> $request->price,
            "engine"=> $request->engine,
             "year"=> $request->year,
             "model"=> $request->model,
             "fuel_id"=>$fuel_id->id,
             "transmission_id"=>$trans_id->id,
             "brand_id"=>$brand_id->id


        ]);
        return ($car)? $car : null;

    }
}

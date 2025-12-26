<?php

use App\Http\Controllers\Auth\AutheticationController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\Cars\CarManagmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        "msg"=>"welcom to apiCars"
    ],200); ;
});

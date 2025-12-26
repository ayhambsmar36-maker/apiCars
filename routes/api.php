<?php

use App\Http\Controllers\Auth\AutheticationController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\Cars\CarManagmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
/**************************************AUTHETICATION (LOGIN ,REGISTER ,LOGOUT)**********************************************************************************************/
Route::post('/login',[AutheticationController::class, 'store']);
Route::post('/register',[RegisterController::class,'store']);
Route::post('/logout',[AutheticationController::class, 'destroy']);
/***************************************  MODEL CARS   *********************************************************************************************************** */
Route::get('/cars',[CarController::class, 'index']);
Route::middleware('auth:sanctum')->group(function(){
Route::post('/create/car',[CarController::class, 'store']);
Route::get('/show/car/{id}',[CarController::class, 'show']);
Route::put('/update/car/{id}',[CarController::class,'update']);
Route::delete('/delete/car/{id}',[CarController::class,'destroy']);
});
/**************************** CAR MANAGMENT **************************************************************************************************** */
Route::get('/cars/show/{brand}',[CarManagmentController::class,'showCar_by_brand']);
Route::post('/car/favorite/{car}',[CarManagmentController::class, 'favorite'])->middleware('auth:sanctum');
Route::get('cars/favorites',[CarManagmentController::class,'favorites' ])->middleware('auth:sanctum');

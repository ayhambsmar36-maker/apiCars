<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Car;

class Fuel extends Model
{
    public $timestamps = false;
    public function cars(){
        return $this->hasMany(Car::class,'fuel_id');
    }
}

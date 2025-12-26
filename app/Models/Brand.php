<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Car;

class Brand extends Model
{
  public $timestamps = false;
    protected $table='brands';
     public function cars(){
        return $this->hasMany(Car::class,'brand_id');
    }
}

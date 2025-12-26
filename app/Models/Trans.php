<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Car;

class Trans extends Model
{
    protected $table="transmissions";
    public $timestamps = false;

    public function cars(){
        return $this->hasMany(Car::class,"transmission_id");
    }
}

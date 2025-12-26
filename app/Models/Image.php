<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Car;

class Image extends Model
{
    
    protected $fillable = [
        'url',
        'car_id'
    ];
    public function car(){
        return $this->belongsTo(Car::class);
    }
}

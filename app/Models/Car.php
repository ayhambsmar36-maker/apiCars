<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Fuel;
use App\Models\Brand;
use App\Models\Trans;
use App\Models\Image;
class Car extends Model
{
    protected $fillable = [
        'name',
            'description',
            "price",
            "engine",
             "year",
             "model",
             "fuel_id",
             "transmission_id",
             "brand_id",

    ];
    public function fuel(){
        return $this->belongsTo(Fuel::class,'fuel_id');
    }
    public function brand(){
        return $this->belongsTo(brand::class,'brand_id');
    }
    public function trans(){
        return $this->belongsTo(Trans::class,'transmission_id');
    }
    public function images(){
        return $this->hasMany(Image::class);
    }
}

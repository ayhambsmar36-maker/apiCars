<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $table = "favorites";
    public $timestamps = false;
    protected $fillable = [
        "user_id",
        "car_id"
    ];
    public function users(){
        return $this->belongsToMany(User::class);
    }
}

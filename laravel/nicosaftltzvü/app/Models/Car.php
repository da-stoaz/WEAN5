<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = ['brand', 'model', 'mileage'];

    protected $table = "cars";

    public function owner(){
        return $this->belongsTo(Driver::class, 'driver_id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{

    protected $table = "drivers";

    protected $fillable = ["name", "ssn", "birthdate"];

    protected $casts = [
        'birthdate' => 'date',  // Carbon-Objekt statt String
    ];


    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}

<?php

namespace App\Models;

use App\Enums\HeatpumpType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Heatpump extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type'];
    protected $table = "heatpump";

    protected $casts = [
        "type" => HeatpumpType::class,
    ];
    
    public function performanceData(){
        return $this->hasMany(PerformanceData::class);
    }

}

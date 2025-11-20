<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceData extends Model
{
    use HasFactory;
    protected $table = "performance_data";

    public $timestamps = false;

    protected $fillable = [];

    public function heatpump()
    {
        return $this->belongsTo(Heatpump::class);
    }
}

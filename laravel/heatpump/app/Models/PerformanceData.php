<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceData extends Model
{
    use HasFactory;
    protected $table = "performance_data";

    public $timestamps = false;

    protected $fillable = [
        'heatpump_id',
        'outside_temp',
        'inside_temp',
        'supply_temp',
        'return_temp',
        'recorded_at',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
    ];

    public function heatpump()
    {
        return $this->belongsTo(Heatpump::class);
    }
}

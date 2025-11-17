<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Heatpump;
use App\Models\PerformanceData;

class HeatpumpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Heatpump::factory(12)
        ->has(PerformanceData::factory()->count(20))
        ->create();
    }
}

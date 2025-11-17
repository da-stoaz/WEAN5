<?php

namespace Database\Seeders;

use App\Models\PerformanceData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PerformanceDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PerformanceData::factory()->count(50)->create();
    }
}

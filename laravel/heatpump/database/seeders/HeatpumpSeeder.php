<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Heatpump;

class HeatpumpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Heatpump::factory()->count(12)->create();
    }
}

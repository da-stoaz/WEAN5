<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PerformanceData>
 */
class PerformanceDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $supplyTemp = $this->faker->randomFloat(1, 25, 45);

        $returnTemp = $supplyTemp - $this->faker->randomFloat(1, 4, 10);

        return [
            // "heatpump_id" is REMOVED. Laravel will add it.

            "outside_temp" => $this->faker->randomFloat(1, -10, 20),
            "inside_temp" => $this->faker->randomFloat(1, 19, 23),
            "supply_temp" => $supplyTemp,
            "return_temp" => $returnTemp,
            "recorded_at" => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}

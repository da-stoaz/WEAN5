<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Heatpump>
 */
class HeatpumpFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => $this->faker->name,
            "type" => $this->faker->randomElement(["Air-to-Water","Brine-to-Water", "Water-to-Water", "Air-to-Air"]),
        ];
    }
}

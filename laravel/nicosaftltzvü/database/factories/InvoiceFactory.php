<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'Name'          => $this->faker->name,
            'PriceNet'      => $this->faker->numberBetween(100, 1000),
            'PriceGross'    => $this->faker->numberBetween(80, 800),
            'Vat'           => $this->faker->numberBetween(10, 20),
            'UserClearing'  => $this->faker->firstName,
            'ClearingDate'  => now(),
        ];
    }
}

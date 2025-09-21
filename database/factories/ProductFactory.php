<?php

namespace Database\Factories;

use Domain\Company\Models\Company;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'is_active' => $this->faker->boolean(),
            'supplier_id' => Company::isSchut()->first()->id,
            'unit_price' => $this->faker->randomFloat(2, 10, 1000),
        ];
    }
}

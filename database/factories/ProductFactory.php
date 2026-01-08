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
            'article_number' => strtoupper($this->faker->bothify('###.###')),
            'brand' => $this->faker->randomElement(['Mitutoyo', 'Tesa', 'Filetta']),
            'description' => $this->faker->sentence(),
            'is_active' => true,
            'supplier_id' => Company::where('is_schut', true)->first()->id,
            'unit_price' => $this->faker->randomFloat(2, 50, 500),
        ];
    }

    /**
     * Set a specific brand.
     */
    public function brand(string $brand): static
    {
        return $this->state(fn (array $attributes) => [
            'brand' => $brand,
        ]);
    }

    /**
     * Mark as inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Create a caliper (schuifmaat).
     */
    public function caliper(): static
    {
        return $this->state(function (array $attributes) {
            $range = $this->faker->randomElement(['0-150mm', '0-200mm', '0-300mm', '0-500mm']);
            $resolution = $this->faker->randomElement(['0.01mm', '0.02mm', '0.05mm']);

            return [
                'name' => "Digitale schuifmaat {$range}",
                'description' => "Digitale schuifmaat met meetbereik {$range} en resolutie {$resolution}. IP67 bescherming.",
                'unit_price' => $this->faker->randomFloat(2, 80, 450),
            ];
        });
    }

    /**
     * Create a tape measure (rolmaat).
     */
    public function tapeMeasure(): static
    {
        return $this->state(function (array $attributes) {
            $length = $this->faker->randomElement(['3m', '5m', '8m', '10m', '15m', '20m', '30m', '50m']);

            return [
                'name' => "Rolmaat {$length}",
                'description' => "Professionele rolmaat {$length} met stalen lint en automatische terugloop.",
                'unit_price' => $this->faker->randomFloat(2, 25, 180),
            ];
        });
    }

    /**
     * Create a micrometer (schroefmaat).
     */
    public function micrometer(): static
    {
        return $this->state(function (array $attributes) {
            $range = $this->faker->randomElement(['0-25mm', '25-50mm', '50-75mm', '75-100mm', '100-125mm']);
            $resolution = $this->faker->randomElement(['0.001mm', '0.01mm']);

            return [
                'name' => "Buitenschroefmaat {$range}",
                'description' => "Digitale buitenschroefmaat met meetbereik {$range} en resolutie {$resolution}. Hardmetalen meetvlakken.",
                'unit_price' => $this->faker->randomFloat(2, 120, 650),
            ];
        });
    }
}

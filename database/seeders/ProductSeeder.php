<?php

namespace Database\Seeders;

use Database\Factories\ProductFactory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Seed the database with 50 measuring instruments from Mitutoyo, Tesa, and Filetta.
     *
     * Products include:
     * - Schuifmaten (calipers)
     * - Rolmaten (tape measures)
     * - Schroefmaten (micrometers)
     */
    public function run(): void
    {
        $brands = ['Mitutoyo', 'Tesa', 'Filetta'];

        // Create calipers (schuifmaten) - 18 products (6 per brand)
        foreach ($brands as $brand) {
            ProductFactory::new()
                ->count(6)
                ->brand($brand)
                ->caliper()
                ->create();
        }

        // Create tape measures (rolmaten) - 15 products (5 per brand)
        foreach ($brands as $brand) {
            ProductFactory::new()
                ->count(5)
                ->brand($brand)
                ->tapeMeasure()
                ->create();
        }

        // Create micrometers (schroefmaten) - 15 products (5 per brand)
        foreach ($brands as $brand) {
            ProductFactory::new()
                ->count(5)
                ->brand($brand)
                ->micrometer()
                ->create();
        }

        // Create 2 inactive products for testing
        ProductFactory::new()
            ->count(2)
            ->caliper()
            ->inactive()
            ->create();
    }
}

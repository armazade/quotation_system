<?php

namespace Database\Factories;

use Database\Seeders\DatabaseSeeder;
use Domain\Company\Enums\CountryType;
use Domain\Company\Models\CompanyLocation;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyLocationFactory extends Factory
{
    protected $model = CompanyLocation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $data = [
            'is_default' => false,
            'address_line_1' => fake()->streetName(),
            'address_line_2' => fake()->randomNumber(2),
            'zip_code' => fake()->postcode(),
            'city' => fake()->city(),
            'country' => fake()->randomElement(CountryType::cases())->value,
        ];

        if (DatabaseSeeder::LOCATION_OVERRIDE) {
            $data['address_line_1'] = 'Portugallaan 44';
            $data['address_line_2'] = null;
            $data['zip_code'] = '9403 DS';
            $data['city'] = 'Assen';
            $data['country'] = CountryType::NL;
        }

        return $data;
    }
}

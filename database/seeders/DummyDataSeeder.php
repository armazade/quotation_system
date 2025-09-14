<?php

namespace Database\Seeders;

use Database\Factories\CompanyFactory;
use Database\Factories\CompanyLocationFactory;
use Database\Factories\UserFactory;
use Domain\Company\Enums\CompanyType;
use Domain\Helper\Enums\LocaleType;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $clientCompany = CompanyFactory::new()
            ->has(
                CompanyLocationFactory::new()
                    ->state([
                        'is_default' => true,
                    ])
                    ->count(1), 'locations'
            )
            ->has(
                CompanyLocationFactory::new()
                    ->count(1), 'locations'
            )
            ->create([
                'name' => 'Client Company',
                'company_type' => CompanyType::CLIENT
            ]);

        $clientUser = UserFactory::new()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'locale_type' => LocaleType::EN,
            'email' => 'user@schut.nl',
        ]);

        $clientUser->attachCompany($clientCompany);
    }
}

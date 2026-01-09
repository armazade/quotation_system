<?php

namespace Database\Seeders;

use Database\Factories\CompanyFactory;
use Database\Factories\CompanyLocationFactory;
use Database\Factories\UserFactory;
use Domain\Company\Enums\CompanyType;
use Domain\User\Enums\RoleType;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $companies = CompanyFactory::new()
            ->state([
                'company_type' => CompanyType::CLIENT,
            ])
            ->count(30)
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
            ->has(
                UserFactory::new()
                    ->count(1), 'users'
            )
            ->create();

        // Assign client role to all users
        foreach ($companies as $company) {
            foreach ($company->users as $user) {
                $user->assignRole(RoleType::CLIENT->value);
            }
        }
    }
}

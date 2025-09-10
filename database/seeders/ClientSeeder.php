<?php

namespace Database\Seeders;

use Database\Factories\CommentFactory;
use Database\Factories\CompanyFactory;
use Database\Factories\CompanyLocationFactory;
use Database\Factories\CreditTransactionFactory;
use Database\Factories\UserFactory;
use Domain\Company\Enums\CompanyType;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        CompanyFactory::new()
            ->state([
                'company_type' => CompanyType::CLIENT
            ])
            ->count(25)
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
                    ->count(1)
            )
            ->create();
    }
}

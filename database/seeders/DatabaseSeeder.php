<?php

namespace Database\Seeders;

use Domain\Company\Enums\CompanyType;
use Domain\Company\Models\Company;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public const LOCATION_OVERRIDE = false;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $seeders = [];
        $seeders[] = RolePermissionSeeder::class;
        $seeders[] = SchutCompanyDataSeeder::class;
        $seeders[] = ProductSeeder::class;
        $seeders[] = DummyDataSeeder::class;
        $seeders[] = ClientSeeder::class;
        $seeders[] = QuotationSeeder::class;

        $this->call($seeders);

    }
}

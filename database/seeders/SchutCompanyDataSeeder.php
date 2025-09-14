<?php

namespace Database\Seeders;

use Database\Factories\CompanyFactory;
use Database\Factories\CompanyLocationFactory;
use Database\Factories\UserFactory;
use Domain\Company\Enums\CompanyType;
use Domain\Company\Enums\CountryCodeType;
use Domain\Company\Enums\CountryType;
use Domain\Helper\Enums\EnvironmentType;
use Domain\Helper\Enums\LocaleType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class SchutCompanyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $schut = CompanyFactory::new()
            ->has(
                CompanyLocationFactory::new([
                    'is_default' => true,
                    'address_line_1' => 'Duinkerkenstraat 21',
                    'address_line_2' => null,
                    'zip_code' => '9723 BN',
                    'city' => 'Groningen',
                    'country' => CountryType::NL,
                ])->count(1), 'locations')
            ->create([
                'name' => 'Schut',
                'company_type' => CompanyType::SUPPLIER,
                'is_schut' => true,
                'phone_country_code' => CountryCodeType::NL,
                'phone_number' => 000000000,
                'email' => 'info@schut.nl',
                'website' => 'https://www.schut.nl',
                'iban_number' => 'NL41INGB0000000000',
                'bic_number' => 'INGBL2A',
                'coc_number' => '00000000',
                'vat_number' => 'NL000000000B01',
            ]);

        $developer = UserFactory::new()->create([
            'first_name' => 'Developer',
            'last_name' => 'Schut',
            'locale_type' => LocaleType::EN,
            'email' => 'developer@schut.nl',
        ]);

        $developer->attachCompany($schut, isSuperUser: true, isAdmin: true);

        $tom = UserFactory::new()->create([
            'first_name' => 'Tom',
            'last_name' => 'van der Voort',
            'locale_type' => LocaleType::NL,
            'email' => 'tom@schut.nl',
        ]);

        $tom->attachCompany($schut, isAdmin: true);

        $bronno = UserFactory::new()->create([
            'first_name' => 'Bronno',
            'last_name' => 'Schut',
            'locale_type' => LocaleType::NL,
            'email' => 'bronno@schut.nl',
        ]);

        $bronno->attachCompany($schut, isAdmin: true);

        $george = UserFactory::new()->create([
            'first_name' => 'George',
            'last_name' => 'Schut',
            'locale_type' => LocaleType::NL,
            'email' => 'george@schut.nl',
        ]);

        $george->attachCompany($schut, isAdmin: true);

        if (!App::environment(EnvironmentType::PRODUCTION->value)) {
            $superAdmin = UserFactory::new()->create([
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'locale_type' => LocaleType::EN,
                'email' => 'super_admin@schut.nl',
            ]);

            $superAdmin->attachCompany($schut, isSuperUser: true, isAdmin: true);

            $admin = UserFactory::new()->create([
                'first_name' => 'Normal',
                'last_name' => 'Admin',
                'locale_type' => LocaleType::EN,
                'email' => 'admin@schut.nl',
            ]);

            $admin->attachCompany($schut, isAdmin: true);
        }
    }
}

<?php

namespace Database\Seeders;

use Database\Factories\QuotationFactory;
use Database\Factories\QuotationLineFactory;
use Domain\Company\Enums\CompanyType;
use Domain\Company\Models\Company;
use Domain\Quotation\Enums\QuotationStatusType;
use Illuminate\Database\Seeder;

class QuotationSeeder extends Seeder
{
    public function run(): void
    {
        $clients = Company::where('company_type', CompanyType::CLIENT)->get();

        foreach ($clients as $client) {
            $user = $client->users()->first();

            // Create 1-5 quotations per client
            $quotationCount = fake()->numberBetween(1, 5);

            for ($i = 0; $i < $quotationCount; $i++) {
                $status = fake()->randomElement(QuotationStatusType::cases());

                $quotation = QuotationFactory::new()
                    ->forCompany($client)
                    ->state([
                        'user_id' => $user?->id,
                        'status' => $status->value,
                        'quotation_sent_at' => $status !== QuotationStatusType::DRAFT
                            ? fake()->dateTimeBetween('-30 days', 'now')
                            : null,
                    ])
                    ->create();

                // Create 1-5 product lines per quotation
                $lineCount = fake()->numberBetween(1, 5);

                QuotationLineFactory::new()
                    ->forQuotation($quotation)
                    ->count($lineCount)
                    ->create();
            }
        }
    }
}

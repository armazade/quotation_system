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
                // Weight towards IN_REVIEW status for demo purposes
                $statusOptions = [
                    QuotationStatusType::IN_REVIEW,
                    QuotationStatusType::IN_REVIEW,
                    QuotationStatusType::ACTIVE,
                    QuotationStatusType::EXPIRED,
                ];
                $status = fake()->randomElement($statusOptions);

                $createdAt = fake()->dateTimeBetween('-5 months', 'now');

                $quotation = QuotationFactory::new()
                    ->forCompany($client)
                    ->state([
                        'user_id' => $user?->id,
                        'status' => $status->value,
                        'quotation_sent_at' => $createdAt,
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt,
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

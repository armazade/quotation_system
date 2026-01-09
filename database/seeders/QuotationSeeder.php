<?php

namespace Database\Seeders;

use Database\Factories\QuotationFactory;
use Database\Factories\QuotationLineFactory;
use Domain\Company\Enums\CompanyType;
use Domain\Company\Models\Company;
use Domain\Quotation\Enums\QuotationDurationType;
use Domain\Quotation\Enums\QuotationStatusType;
use Illuminate\Database\Seeder;

class QuotationSeeder extends Seeder
{
    public function run(): void
    {
        $clients = Company::where('company_type', CompanyType::CLIENT)->get();
        $validityDays = QuotationDurationType::REGULAR->value;

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
                $quotationSentAt = null;
                $createdAt = null;

                if ($status === QuotationStatusType::IN_REVIEW) {
                    // IN_REVIEW: created within last 7 days, not sent yet
                    $createdAt = fake()->dateTimeBetween('-7 days', 'now');
                    $quotationSentAt = null;
                } elseif ($status === QuotationStatusType::ACTIVE) {
                    // ACTIVE: sent within last 14 days (valid)
                    $quotationSentAt = fake()->dateTimeBetween('-' . ($validityDays - 1) . ' days', 'now');
                    // Created before or same day as sent
                    $createdAt = fake()->dateTimeBetween('-' . $validityDays . ' days', $quotationSentAt);
                } elseif ($status === QuotationStatusType::EXPIRED) {
                    // EXPIRED: sent exactly 14+ days ago (just expired)
                    $quotationSentAt = fake()->dateTimeBetween('-' . ($validityDays + 7) . ' days', '-' . $validityDays . ' days');
                    // Created before or same day as sent
                    $createdAt = fake()->dateTimeBetween('-' . ($validityDays + 14) . ' days', $quotationSentAt);
                }

                $quotation = QuotationFactory::new()
                    ->forCompany($client)
                    ->state([
                        'user_id' => $user?->id,
                        'status' => $status->value,
                        'quotation_sent_at' => $quotationSentAt,
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

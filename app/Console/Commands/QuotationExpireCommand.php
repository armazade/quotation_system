<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Domain\Quotation\Enums\QuotationDurationType;
use Domain\Quotation\Enums\QuotationStatusType;
use Domain\Quotation\Models\Quotation;
use Illuminate\Console\Command;

class QuotationExpireCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'operation:quotation:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expires all quotations that are older than X days';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $expirationDate = Carbon::now()->subDays(QuotationDurationType::REGULAR->value);

        $expiredCount = Quotation::query()
            ->where('status', QuotationStatusType::ACTIVE)
            ->where('quotation_sent_at', '<', $expirationDate)
            ->update(['status' => QuotationStatusType::EXPIRED->value]);

        $this->info("Expired {$expiredCount} quotation(s) older than " . QuotationDurationType::REGULAR->value . " days.");

        return self::SUCCESS;
    }
}

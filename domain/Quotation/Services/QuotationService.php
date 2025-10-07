<?php

namespace Domain\Quotation\Services;

use Domain\Quotation\Models\Quotation;
use Domain\Company\Models\Company;
use Domain\Quotation\Enums\QuotationStatusType;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class QuotationService
{
    public static function adminIndex(?QuotationStatusType $status = null, ?string $reference = null, ?string $companyName = null, int $perPage = 10): LengthAwarePaginator
    {
        $query = Quotation::query()
            ->with('company')
            ->orderByDesc('created_at');

        if (isset($status)) {
            $query->where('status', $status);
        }


        if (isset($companyName)) {
            $query->whereHas('company', function ($q) use ($companyName) {
                $q->where('name', 'like', '%' . $companyName . '%');
            });
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public static function store(object $data): Quotation
    {
        return DB::transaction(function () use ($data) {
            return Quotation::create([
                'company_id' => $data->company_id,
                'user_id' => auth()->id(),
                'status' => QuotationStatusType::DRAFT,
            ]);
        });
    }

    public static function update(Quotation $quotation, object $data): Quotation
    {
        $quotation->company_id = $data->company_id;
        $quotation->reference = $data->reference;

        return $quotation;
    }

    public static function destroy(Quotation $quotation): void
    {
        DB::transaction(function () use ($quotation) {
            $quotation->lines()->delete();
            $quotation->delete();
        });
    }
}

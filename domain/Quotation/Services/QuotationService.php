<?php

namespace Domain\Quotation\Services;

use Domain\Quotation\Enums\QuotationLineType;
use Domain\Quotation\Enums\QuotationStatusType;
use Domain\Quotation\Models\Quotation;
use Domain\Quotation\Models\QuotationLine;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class QuotationService
{
    public static function adminIndex(?QuotationStatusType $status = null, ?string $reference = null, ?string $companyName = null, int $perPage = 10): LengthAwarePaginator
    {
        $query = Quotation::query()
            ->with(['company', 'lines'])
            ->orderByDesc('created_at');

        if (isset($status)) {
            $query->where('status', $status);
        }

        if (isset($reference)) {
            $query->where('reference', 'like', '%'.$reference.'%');
        }

        if (isset($companyName)) {
            $query->whereHas('company', function ($q) use ($companyName) {
                $q->where('name', 'like', '%'.$companyName.'%');
            });
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public static function index(string $companyId, ?string $reference = null, int $perPage = 10): LengthAwarePaginator
    {
        $query = Quotation::query()
            ->where('company_id', $companyId)
            ->notExpired()
            ->with(['lines', 'lines.product'])
            ->orderByDesc('created_at');

        if (isset($reference)) {
            $query->where('reference', 'like', '%'.$reference.'%');
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

    public static function storeWithLines(object $data): Quotation
    {
        return DB::transaction(function () use ($data) {
            $quotation = Quotation::create([
                'company_id' => $data->company_id,
                'user_id' => auth()->id(),
                'status' => QuotationStatusType::IN_REVIEW,
                'reference' => $data->reference ?? null,
            ]);

            foreach ($data->lines as $lineData) {
                QuotationLine::create([
                    'quotation_id' => $quotation->id,
                    'product_id' => $lineData['product_id'],
                    'description' => $lineData['description'],
                    'quantity' => $lineData['quantity'],
                    'unit_price' => $lineData['unit_price'],
                    'line_type' => QuotationLineType::PRODUCT,
                    'has_custom_description' => false,
                ]);
            }

            return $quotation->load('lines.product');
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

    public static function approve(Quotation $quotation): Quotation
    {
        return DB::transaction(function () use ($quotation) {
            $quotation->status = QuotationStatusType::ACTIVE;
            $quotation->save();

            return $quotation;
        });
    }

    public static function getPendingReview(int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return Quotation::query()
            ->where('status', QuotationStatusType::IN_REVIEW)
            ->with(['company', 'lines'])
            ->orderByDesc('created_at')
            ->take($limit)
            ->get();
    }
}

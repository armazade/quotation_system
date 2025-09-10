<?php

namespace Domain\Quotation\Gates;

use Domain\Company\Enums\CompanyType;
use Domain\Quotation\Enums\QuotationStatusType;
use Domain\Quotation\Models\Quotation;
use Domain\User\Models\User;

class QuotationGate
{
    public static function update(?User $user, ?Quotation $quotation): bool
    {
        return static::show($user, $quotation);
    }

    public static function show(?User $user, ?Quotation $quotation): bool
    {
        if (!static::exists($user, $quotation)) {
            return false;
        }

        if ($user->isAdmin()) {
            return true;
        }

        if ($user->company_id !== $quotation->company_id) {
            return false;
        }

        return true;
    }

    public static function exists(?User $user, ?Quotation $quotation): bool
    {
        if (!$user || !$quotation) {
            return false;
        }

        return true;
    }

    public static function store(?User $user): bool
    {
        if (!$user || !$user->company_id) {
            return false;
        }

        if ($user->company->company_type === CompanyType::SUPPLIER && !$user->company->is_schut) {
            return false;
        }

        return true;
    }

    public static function send(?User $user, ?Quotation $quotation): bool
    {
        if (!static::updateDraft($user, $quotation)) {
            return false;
        }

        if ($quotation->total_price <= 0) {
            return false;
        }

        return true;
    }

    public static function updateDraft(?User $user, ?Quotation $quotation): bool
    {
        if (!static::exists($user, $quotation)) {
            return false;
        }

        if (!$user->isAdmin()) {
            return false;
        }

        if ($quotation->status !== QuotationStatusType::DRAFT) {
            return false;
        }

        return true;
    }
}

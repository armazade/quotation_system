<?php

namespace Domain\Company\Gates;

use Domain\Company\Models\Company;
use Domain\Order\Enums\OrderStatusType;
use Domain\User\Gates\UserGate;
use Domain\User\Models\User;

class CompanyGate
{
    public static function adminUpdate(?User $user): bool
    {
        if (!UserGate::existsWithCompany($user)) {
            return false;
        }

        if (!UserGate::isAdmin($user)) {
            return false;
        }

        return true;
    }

    public static function destroy(?User $user, ?Company $company): bool
    {
        if (!$user || !$company) {
            return false;
        }

        if (!UserGate::isSuperAdmin($user)) {
            return false;
        }

        if ($company->orders()->where('status', OrderStatusType::COMPLETED)->count() !== 0) {
            return false;
        }

        if ($company->products()->count() !== 0) {
            return false;
        }

        return true;
    }
}

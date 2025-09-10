<?php

namespace Domain\User\Gates;

use Domain\Company\Enums\CompanyType;
use Domain\User\Models\User;

class UserGate
{
    public static function isSuperAdmin(?User $user): bool
    {
        if (!static::existsWithCompany($user)) {
            return false;
        }

        if (!$user->isSuperAdmin()) {
            return false;
        }

        return true;
    }

    public static function existsWithCompany(?User $user): bool
    {
        if (!$user || !$user->company) {
            return false;
        }

        return true;
    }

    public static function isAdmin(?User $user): bool
    {
        if (!static::existsWithCompany($user)) {
            return false;
        }

        if (!$user->isAdmin()) {
            return false;
        }

        return true;
    }

    public static function isClient(?User $user): bool
    {
        if (!static::existsWithCompany($user)) {
            return false;
        }

        if ($user->company->company_type !== CompanyType::CLIENT) {
            return false;
        }

        return true;
    }
}

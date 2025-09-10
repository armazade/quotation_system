<?php

namespace Domain\Company\Gates;

use Domain\Company\Models\CompanyLocation;
use Domain\User\Gates\UserGate;
use Domain\User\Models\User;

class CompanyLocationGate
{
    public static function destroy(?User $user, ?CompanyLocation $companyLocation): bool
    {
        if (!UserGate::existsWithCompany($user)) {
            return false;
        }

        if (!$companyLocation) {
            return false;
        }

        if ($companyLocation->is_default) {
            return false;
        }

        if ($user->isAdmin()) {
            return true;
        }

        if ($user->company_id !== $companyLocation->company_id) {
            return false;
        }

        return true;
    }
}

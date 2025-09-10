<?php

namespace Domain\Helper\Castables;

use Domain\Company\Models\Company;
use WendellAdriel\ValidatedDTO\Casting\Castable;

class CompanyCast implements Castable
{
    public function cast(string $property, mixed $value): ?Company
    {
        return Company::query()
            ->where('id', $value)
            ->first();
    }
}

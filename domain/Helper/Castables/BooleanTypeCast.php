<?php

namespace Domain\Helper\Castables;

use Domain\Product\Enums\BooleanType;
use WendellAdriel\ValidatedDTO\Casting\Castable;

class BooleanTypeCast implements Castable
{
    public function cast(string $property, mixed $value): bool
    {
        $type = BooleanType::tryFrom($value);

        return match ($type) {
            BooleanType::YES => true,
            default => false,
        };
    }
}

<?php

namespace Domain\Product\Enums;

use Domain\Helper\Classes\EnumTrait;

enum ProcessingTermType: string
{
    use EnumTrait;

    case REGULAR = 'regular';
}

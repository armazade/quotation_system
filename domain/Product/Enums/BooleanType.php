<?php

namespace Domain\Product\Enums;

use Domain\Helper\Classes\EnumTrait;

enum BooleanType: string
{
    use EnumTrait;

    case YES = 'yes';
    case NO = 'no';
}

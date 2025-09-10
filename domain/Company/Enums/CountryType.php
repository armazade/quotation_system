<?php

namespace Domain\Company\Enums;

use Domain\Helper\Classes\EnumTrait;

enum CountryType: string
{
    use EnumTrait;

    case NL = 'nl';
    case BE = 'be';
    case DE = 'de';
}

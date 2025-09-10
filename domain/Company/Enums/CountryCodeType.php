<?php

namespace Domain\Company\Enums;

use Domain\Helper\Classes\EnumTrait;

enum CountryCodeType: string
{
    use EnumTrait;

    case NL = '+31';
    case BE = '+32';
    case DE = '+49';
}

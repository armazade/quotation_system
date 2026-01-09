<?php

namespace Domain\Helper\Enums;

use Domain\Helper\Classes\EnumTrait;

enum LocaleType: string
{
    use EnumTrait;

    case EN = 'en';
    case NL = 'nl';
    case DE = 'de';
    case FR = 'fr';
}

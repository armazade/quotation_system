<?php

namespace Domain\Quotation\Enums;

use Domain\Helper\Classes\EnumTrait;

enum QuotationDurationType: int
{
    use EnumTrait;

    case REGULAR = 14;
}

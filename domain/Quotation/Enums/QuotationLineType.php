<?php

namespace Domain\Quotation\Enums;

use Domain\Helper\Classes\EnumTrait;

enum QuotationLineType: string
{
    use EnumTrait;

    case PRODUCT = 'product';
    case DELIVERY = 'delivery';
}

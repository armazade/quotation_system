<?php

namespace Domain\Quotation\Enums;

enum QuotationPageType: int
{
    case PRODUCT_TYPE = 0;
    case EXTRA_COSTS = 1;
    case QUANTITIES = 2;
    case PRICING = 3;
}

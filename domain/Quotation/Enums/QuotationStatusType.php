<?php

namespace Domain\Quotation\Enums;

use Domain\Helper\Classes\EnumTrait;

enum QuotationStatusType: string
{
    use EnumTrait;

    case DRAFT = 'draft';
    case IN_REVIEW = 'in_review';
    case ACTIVE = 'active';
    case EXPIRED = 'expired';
}

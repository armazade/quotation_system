<?php

namespace Domain\Quotation\Enums;

use Domain\Helper\Classes\EnumTrait;

enum QuotationStatusType: string
{
    use EnumTrait;

    case DRAFT = 'draft';
    case CLOSED = 'closed';
    case EXPIRED = 'expired';
}

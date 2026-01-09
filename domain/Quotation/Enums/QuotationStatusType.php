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

    public static function getActiveStatusesDropdown(bool $hasEmptyRow = false): array
    {
        $result = [];

        if ($hasEmptyRow) {
            $result[''] = '';
        }

        $result[self::IN_REVIEW->value] = self::IN_REVIEW->value;
        $result[self::ACTIVE->value] = self::ACTIVE->value;
        $result[self::EXPIRED->value] = self::EXPIRED->value;

        return $result;
    }
}

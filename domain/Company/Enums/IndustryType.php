<?php

namespace Domain\Company\Enums;

use Domain\Helper\Classes\EnumTrait;

enum IndustryType: string
{
    use EnumTrait;

    case PUBLICITY = 'publicity';
    case FASHION = 'fashion';
    case WORK_CLOTHING = 'work_clothing';
    case SPORTS = 'sports';
    case PRINTING_OFFICE = 'printing_office';
    case OTHER = 'other';
}

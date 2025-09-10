<?php

namespace Domain\Product\Enums;

use Domain\Helper\Classes\EnumTrait;

enum ColumnType: string
{
    use EnumTrait;

    case QUANTITY_MIN = 'quantity_min';
    case QUANTITY_MAX = 'quantity_max';

}

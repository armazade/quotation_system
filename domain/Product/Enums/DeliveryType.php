<?php

namespace Domain\Product\Enums;

use Domain\Helper\Classes\EnumTrait;

enum DeliveryType: string
{
    use EnumTrait;

    case SHIPPING = 'shipping';
    case PICK_UP = 'pick_up';
}

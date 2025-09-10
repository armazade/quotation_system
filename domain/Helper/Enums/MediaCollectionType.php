<?php

namespace Domain\Helper\Enums;

enum MediaCollectionType: string
{
    case TECHNICAL_DRAWING = 'technical_drawing';
    case PACKING_SLIP = 'packing_slip';
    case SHIPPING_LABEL = 'shipping_label';
    case PROFILE_IMAGES = 'profile_images';
}

<?php

namespace Domain\Quotation\Enums;

use Domain\Helper\Classes\EnumTrait;

enum FileUploadType: string
{
    use EnumTrait;

    case FILE = 'file';
    case LINK = 'link';
}

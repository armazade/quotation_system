<?php

namespace Domain\Helper\Enums;

enum EnvironmentType: string
{
    case LOCAL = 'local';
    case STAGING = 'staging';
    case PRODUCTION = 'production';
}

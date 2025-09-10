<?php

namespace Domain\Helper\Services;

use Domain\Helper\Enums\FlashMessageType;
use Domain\Helper\Enums\FlashType;

class FlashMessageService
{
    public static function type(): string
    {
        return 'message';
    }

    public static function sendError(FlashMessageType $message): array
    {
        return static::prepare(FlashType::ERROR, $message);
    }

    private static function prepare(FlashType $type, FlashMessageType $message): array
    {
        return [
            'type' => $type,
            'value' => $message,
        ];
    }

    public static function sendSuccess(FlashMessageType $message): array
    {
        return static::prepare(FlashType::SUCCESS, $message);
    }
}

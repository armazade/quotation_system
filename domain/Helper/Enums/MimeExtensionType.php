<?php

namespace Domain\Helper\Enums;

enum MimeExtensionType: string
{
    case PDF = 'pdf';
    case EPS = 'eps';
    case AI = 'ai';
    case PSD = 'psd';
    case PNG = 'png';
    case JPG = 'jpg';
    case JPEG = 'jepg';
    case SVG = 'svg';

    public static function parsedCases(): array
    {
        $result = [];
        foreach (static::cases() as $case) {
            $result[] = '.' . $case->value;
        }

        return $result;
    }
}

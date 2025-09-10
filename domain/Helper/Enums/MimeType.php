<?php

namespace Domain\Helper\Enums;

enum MimeType: string
{
    case PDF = 'application/pdf';
    case EPS_AI_PS = 'application/postscript';
    case PSD = 'image/vnd.adobe.photoshop';
    case PNG = 'image/png';
    case JPG_JPEG = 'image/jpeg';
    case SVG = 'image/svg+xml';
}

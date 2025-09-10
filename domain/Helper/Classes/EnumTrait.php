<?php

namespace Domain\Helper\Classes;

trait EnumTrait
{
    public static function convertToDropdownList($hasEmptyRow = false): array
    {
        $result = [];

        if ($hasEmptyRow) {
            $result[''] = '';
        }

        foreach (static::cases() as $case) {
            $result[$case->value] = $case->value;
        }

        return $result;
    }
}

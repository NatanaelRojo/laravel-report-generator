<?php

namespace App\Traits;

trait HasEnumMethods
{
    /**
     * Get enum values as an array of strings.
     *
     * @return array<string>
     */
    public static function valuesToArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function getArrayForFilamentSelector(): array
    {
        $options = [];
        foreach (self::cases() as $case) {
            $options[$case->value] = $case->value;
        }

        return $options;
    }
}

<?php

namespace app\Traits;

use UnitEnum;

trait Helper
{
    protected function isProduction(): bool
    {
        return env('production') === 'production';
    }

    public static function hasFlag($values, int|UnitEnum $flag): bool
    {
        $flagValue = ($flag instanceof UnitEnum
            ? $flag->value
            : $flag);

        if ($flagValue === 0) {
            return false;
        }

        return ($flagValue & $values) === $flagValue;
    }
}

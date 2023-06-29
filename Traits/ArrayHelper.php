<?php

namespace app\Traits;

trait ArrayHelper
{
    public static function replace_array_key(array &$item, $oldKey, $newKey): void
    {
        $item[$newKey] = $item[$oldKey];
        unset($item[$oldKey]);
    }
}

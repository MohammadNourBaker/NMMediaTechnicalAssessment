<?php

namespace app\Traits;

trait EnumToArray
{
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function getKeys(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function getRandomValue(): string|int|array
    {
        $values = self::getValues();

        return $values[array_rand($values)];
    }

    public static function getValue($name): int|string|null
    {
        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return $case->value;
            }
        }

        return null;
    }

    public static function getKey($value): string
    {
        return self::from($value)->name;
    }
}

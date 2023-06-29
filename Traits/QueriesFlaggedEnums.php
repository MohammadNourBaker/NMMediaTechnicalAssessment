<?php

namespace app\Traits;

use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

trait QueriesFlaggedEnums
{
    public function scopeHasFlag(Builder $query, string $column, int|UnitEnum $flag): Builder
    {
        if ($flag instanceof UnitEnum) {
            $flag = $flag->value;
        }

        return $query->whereRaw("{$column} & ? > 0", [$flag]);
    }

    public function scopeNotHasFlag(Builder $query, string $column, int|UnitEnum $flag): Builder
    {

        if ($flag instanceof UnitEnum) {
            $flag = $flag->value;
        }

        return $query->whereRaw("not {$column} & ? > 0", [$flag]);
    }

    public function scopeHasAllFlags(Builder $query, string $column, array $flags): Builder
    {
        $mask = $this->flagsSum($flags);

        return $query->whereRaw("{$column} & ? = ?", [$mask, $mask]);
    }

    /**
     * @param array<int> $flags
     */
    public function scopeHasAnyFlags(Builder $query, string $column, array $flags): Builder
    {
        $mask = $this->flagsSum($flags);

        return $query->whereRaw("{$column} & ? > 0", [$mask]);
    }

    /**
     * @param array<int> $flags
     */
    protected function flagsSum(array $flags): int
    {
        return array_sum($flags);
    }
}

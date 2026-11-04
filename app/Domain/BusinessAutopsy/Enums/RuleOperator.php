<?php

namespace App\Domain\BusinessAutopsy\Enums;

enum RuleOperator: string
{
    case GreaterThan = 'greater_than';
    case GreaterThanOrEqual = 'greater_than_or_equal';
    case LessThan = 'less_than';
    case LessThanOrEqual = 'less_than_or_equal';
    case Equal = 'equal';
    case NotEqual = 'not_equal';

    public function matches(float $actualValue, float $threshold): bool
    {
        return match ($this) {
            self::GreaterThan => $actualValue > $threshold,
            self::GreaterThanOrEqual => $actualValue >= $threshold,
            self::LessThan => $actualValue < $threshold,
            self::LessThanOrEqual => $actualValue <= $threshold,
            self::Equal => $actualValue === $threshold,
            self::NotEqual => $actualValue !== $threshold,
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::GreaterThan => 'lebih besar dari',
            self::GreaterThanOrEqual => 'lebih besar atau sama dengan',
            self::LessThan => 'lebih kecil dari',
            self::LessThanOrEqual => 'lebih kecil atau sama dengan',
            self::Equal => 'sama dengan',
            self::NotEqual => 'tidak sama dengan',
        };
    }

    public function symbol(): string
    {
        return match ($this) {
            self::GreaterThan => '>',
            self::GreaterThanOrEqual => '>=',
            self::LessThan => '<',
            self::LessThanOrEqual => '<=',
            self::Equal => '=',
            self::NotEqual => '!=',
        };
    }
}

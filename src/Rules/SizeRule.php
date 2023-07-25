<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Rules;

use Wrkflow\GetValue\Contracts\RuleContract;

/**
 * Code originally taken from https://github.com/laurynasgadl/php-validator
 */
class SizeRule implements RuleContract
{
    public function __construct(
        protected int|float $value
    ) {
    }

    public function passes(mixed $value): bool
    {
        $size = static::getSize($value);

        // If we get float 10.0 and the value is int 10 we should take this as equal.
        return $size === $this->value || ((int) $size === $this->value);
    }

    public static function getSize(array|float|int|bool|string|null $value): int|float
    {
        if (is_array($value)) {
            return count($value);
        }

        if (is_string($value)) {
            return strlen($value);
        }

        if (is_bool($value)) {
            return (int) $value;
        }

        if ($value === null) {
            return 0;
        }

        return $value;
    }
}

<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Rules;

use Wrkflow\GetValue\Contracts\RuleContract;

/**
 * Code originally taken from https://github.com/laurynasgadl/php-validator
 */
class BetweenRule implements RuleContract
{
    public function __construct(
        protected int|float $minValue,
        protected int|float $maxValue
    ) {
    }

    public function passes(mixed $value): bool
    {
        $size = SizeRule::getSize($value);

        return $size >= $this->minValue && $size <= $this->maxValue;
    }
}

<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Rules;

use Wrkflow\GetValue\Contracts\RuleContract;

/**
 * Code originally taken from https://github.com/laurynasgadl/php-validator
 */
class MaxRule implements RuleContract
{
    public function __construct(protected int|float $maxValue)
    {
    }

    public function passes(mixed $value): bool
    {
        return SizeRule::getSize($value) <= $this->maxValue;
    }
}

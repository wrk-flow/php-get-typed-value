<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Rules;

use Wrkflow\GetValue\Contracts\RuleContract;

/**
 * Code originally taken from https://github.com/laurynasgadl/php-validator
 */
class FloatRule implements RuleContract
{
    public function passes(mixed $value): bool
    {
        return is_float($value);
    }
}

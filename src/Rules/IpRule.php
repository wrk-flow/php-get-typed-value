<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Rules;

use Wrkflow\GetValue\Contracts\RuleContract;

/**
 * Code originally taken from https://github.com/laurynasgadl/php-validator
 */
class IpRule implements RuleContract
{
    public function passes(mixed $value): bool
    {
        if (is_string($value) === false) {
            return false;
        }

        return (bool) filter_var($value, FILTER_VALIDATE_IP);
    }
}

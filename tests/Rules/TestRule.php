<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Rules;

use Wrkflow\GetValue\Contracts\RuleContract;

/**
 * Code originally taken from https://github.com/laurynasgadl/php-validator
 */
class TestRule implements RuleContract
{
    public function passes(mixed $value): bool
    {
        return $value === 'test';
    }
}

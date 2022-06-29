<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Rules;

use Wrkflow\GetValue\Contracts\RuleContract;

/**
 * Code originally taken from https://github.com/laurynasgadl/php-validator
 */
class RegexRule implements RuleContract
{
    public function __construct(protected readonly string $pattern)
    {
    }

    public function passes(mixed $value): bool
    {
        if (is_string($value) === false && is_numeric($value) === false) {
            return false;
        }

        $result = preg_match($this->pattern, (string) $value);

        return $result !== false && $result !== 0;
    }
}

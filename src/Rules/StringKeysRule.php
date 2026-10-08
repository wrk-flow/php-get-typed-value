<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Rules;

use Wrkflow\GetValue\Contracts\RuleContract;

class StringKeysRule implements RuleContract
{
    /**
     * @phpstan-assert-if-true array<string, mixed> $value
     */
    public function passes(mixed $value): bool
    {
        if (is_array($value) === false) {
            return false;
        }

        foreach ($value as $key => $_) {
            if (is_string($key) === false) {
                return false;
            }
        }

        return true;
    }
}

<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Rules;

use Wrkflow\GetValue\Contracts\RuleContract;

class HexColorRule implements RuleContract
{
    public function passes(mixed $value): bool
    {
        if (is_string($value) === false) {
            return false;
        }

        return (new RegexRule('/^#{0,1}[A-Fa-f0-9]{3,6}$/'))->passes($value);
    }
}

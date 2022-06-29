<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Transformers;

use Wrkflow\GetValue\Contracts\TransformerContract;
use Wrkflow\GetValue\GetValue;

class TrimString implements TransformerContract
{
    public function beforeValidation(mixed $value, string $key): bool
    {
        return true;
    }

    public function transform(mixed $value, string $key, GetValue $getValue): mixed
    {
        if (is_string($value) === false) {
            return $value;
        }

        return trim($value);
    }
}

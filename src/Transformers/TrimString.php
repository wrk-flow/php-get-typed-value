<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Transformers;

use Wrkflow\GetValue\Contracts\TransformerContract;

class TrimString implements TransformerContract
{
    public function beforeValidation(mixed $value, string $key): bool
    {
        return true;
    }

    public function transform(mixed $value, string $key): mixed
    {
        if (is_string($value) === false) {
            return $value;
        }

        return trim($value);
    }
}

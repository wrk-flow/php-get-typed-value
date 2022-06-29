<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Contracts;

use Wrkflow\GetValue\GetValue;

interface TransformerContract
{
    public function beforeValidation(mixed $value, string $key): bool;

    public function transform(mixed $value, string $key, GetValue $getValue): mixed;
}

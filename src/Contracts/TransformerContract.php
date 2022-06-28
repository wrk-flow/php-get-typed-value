<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Contracts;

interface TransformerContract
{
    public function beforeValidation(mixed $value, string $key): bool;

    public function transform(mixed $value, string $key): mixed;
}

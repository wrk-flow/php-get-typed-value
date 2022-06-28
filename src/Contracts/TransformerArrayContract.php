<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Contracts;

interface TransformerArrayContract extends TransformerContract
{
    public function transform(mixed $value, string $key): array;
}

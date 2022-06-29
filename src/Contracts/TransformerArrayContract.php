<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Contracts;

use Wrkflow\GetValue\GetValue;

interface TransformerArrayContract extends TransformerContract
{
    public function transform(mixed $value, string $key, GetValue $getValue): ?array;
}

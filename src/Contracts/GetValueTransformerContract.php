<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Contracts;

use Wrkflow\GetValue\GetValue;

interface GetValueTransformerContract
{
    public function transform(GetValue $value, string $key): mixed;
}

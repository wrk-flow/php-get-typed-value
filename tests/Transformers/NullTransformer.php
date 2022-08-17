<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Transformers;

use Wrkflow\GetValue\Contracts\GetValueTransformerContract;
use Wrkflow\GetValue\GetValue;

class NullTransformer implements GetValueTransformerContract
{
    public function transform(GetValue $value, string $key): mixed
    {
        return null;
    }
}

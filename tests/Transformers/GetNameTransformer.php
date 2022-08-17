<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Transformers;

use Wrkflow\GetValue\Contracts\GetValueTransformerContract;
use Wrkflow\GetValue\GetValue;

class GetNameTransformer implements GetValueTransformerContract
{
    public function transform(GetValue $value, string $key): string
    {
        return implode(' ', [$value->getRequiredString('name'), $value->getRequiredString('surname')]);
    }
}

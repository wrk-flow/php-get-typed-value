<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Transformers;

use Wrkflow\GetValue\Contracts\GetValueTransformerContract;
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValueTests\Entities\TestEntity;

class TestEntityTransformer implements GetValueTransformerContract
{
    public function transform(GetValue $value, string $key): TestEntity
    {
        return new TestEntity($value->getRequiredString('type'));
    }
}

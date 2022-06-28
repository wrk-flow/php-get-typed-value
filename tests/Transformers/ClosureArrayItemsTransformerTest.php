<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Transformers;

use Closure;
use Wrkflow\GetValue\Contracts\TransformerArrayContract;
use Wrkflow\GetValue\Exceptions\ValidationFailedException;
use Wrkflow\GetValue\Transformers\ClosureArrayItemsTransformer;

class ClosureArrayItemsTransformerTest extends ClosureArrayTransformerTest
{
    protected function getClosure(): Closure
    {
        return function (mixed $value, string $key): string {
            $this->assertEquals('test', $key, 'Key does not match up');

            if (is_string($value) === false) {
                throw new ValidationFailedException($key, 'array value not a string');
            }

            return md5($value);
        };
    }

    protected function getDefaultTransformer(): TransformerArrayContract
    {
        return new ClosureArrayItemsTransformer(onItem: $this->getClosure());
    }

    protected function getBeforeValidationTransformer(): TransformerArrayContract
    {
        return new ClosureArrayItemsTransformer(onItem: $this->getClosure(), beforeValidation: true);
    }

    protected function getForceAfterValidation(): TransformerArrayContract
    {
        return new ClosureArrayItemsTransformer(onItem: $this->getClosure(), beforeValidation: false);
    }
}

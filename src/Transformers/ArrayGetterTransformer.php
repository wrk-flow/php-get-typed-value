<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Transformers;

use Closure;
use Wrkflow\GetValue\Contracts\TransformerArrayContract;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\GetValue;

/**
 * Transforms the value using closure after validation has been done.
 */
class ArrayGetterTransformer implements TransformerArrayContract
{
    /**
     * @param Closure(GetValue,string):array $closure
     * @param bool    $beforeValidation
     */
    public function __construct(
        private readonly Closure $closure,
        private readonly bool $beforeValidation = false
    ) {
    }

    public function beforeValidation(mixed $value, string $key): bool
    {
        return $this->beforeValidation;
    }

    public function transform(mixed $value, string $key, GetValue $getValue): ?array
    {
        if (is_array($value) === false) {
            return null;
        }

        $getItemValue = $getValue->makeInstance(new ArrayData($value));

        return call_user_func_array($this->closure, [$getItemValue, $key]);
    }
}

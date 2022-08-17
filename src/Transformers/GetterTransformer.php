<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Transformers;

use Closure;
use Wrkflow\GetValue\Contracts\GetValueTransformerContract;
use Wrkflow\GetValue\Contracts\TransformerContract;
use Wrkflow\GetValue\DataHolders\AbstractData;
use Wrkflow\GetValue\GetValue;

/**
 * Transforms the value using closure after validation has been done.
 */
class GetterTransformer implements TransformerContract
{
    /**
     * @param Closure(GetValue,string):mixed $closure
     */
    public function __construct(
        private readonly Closure|GetValueTransformerContract $closure,
        private readonly bool $beforeValidation = false
    ) {
    }

    public function beforeValidation(mixed $value, string $key): bool
    {
        return $this->beforeValidation;
    }

    public function transform(mixed $value, string $key, GetValue $getValue): mixed
    {
        $data = $getValue->makeData($value, $key);

        if ($data instanceof AbstractData === false) {
            return null;
        }

        $getItemValue = $getValue->makeInstance($data);

        if ($this->closure instanceof GetValueTransformerContract) {
            return $this->closure->transform($getItemValue, $key);
        }

        return call_user_func_array($this->closure, [$getItemValue, $key]);
    }
}

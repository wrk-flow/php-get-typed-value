<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Transformers;

use Wrkflow\GetValue\DataHolders\AbstractData;
use Closure;
use Wrkflow\GetValue\Contracts\TransformerContract;
use Wrkflow\GetValue\GetValue;

/**
 * Transforms the value using closure after validation has been done.
 */
class GetterTransformer implements TransformerContract
{
    /**
     * @param Closure(GetValue,string):mixed $closure
     * @param bool                           $beforeValidation
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

    public function transform(mixed $value, string $key, GetValue $getValue): mixed
    {
        $data = $getValue->makeData($value, $key);

        if ($data instanceof AbstractData === false) {
            return null;
        }

        $getItemValue = $getValue->makeInstance($data);

        return call_user_func_array($this->closure, [$getItemValue, $key]);
    }
}

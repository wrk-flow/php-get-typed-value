<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Transformers;

use Closure;
use Wrkflow\GetValue\Contracts\TransformerArrayContract;
use Wrkflow\GetValue\GetValue;

/**
 * Transforms the value using closure after validation has been done.
 */
class ArrayTransformer implements TransformerArrayContract
{
    /**
     * @param Closure(array,string):array $closure
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

        return call_user_func_array($this->closure, [$value, $key]);
    }
}

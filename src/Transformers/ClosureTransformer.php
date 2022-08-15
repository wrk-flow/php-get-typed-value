<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Transformers;

use Closure;
use Wrkflow\GetValue\Contracts\TransformerContract;
use Wrkflow\GetValue\GetValue;

/**
 * Transforms the value using closure after validation has been done.
 */
class ClosureTransformer implements TransformerContract
{
    /**
     * @param Closure(mixed,string):mixed $closure Transform the
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
        return call_user_func_array($this->closure, [$value, $key]);
    }
}

<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Transformers;

use Closure;
use Wrkflow\GetValue\Contracts\TransformerArrayContract;

/**
 * Re-build the array with a closure for each item
 */
class ClosureArrayItemsTransformer implements TransformerArrayContract
{
    /**
     * @param Closure(mixed,string):array|null $onItem
     * @param bool                             $beforeValidation
     */
    public function __construct(
        private readonly Closure $onItem,
        private readonly bool $beforeValidation = false
    ) {
    }

    public function beforeValidation(mixed $value, string $key): bool
    {
        return $this->beforeValidation;
    }

    public function transform(mixed $value, string $key): ?array
    {
        if (is_array($value) === false) {
            return null;
        }

        $items = [];
        foreach (array_keys($value) as $index) {
            $items[$index] = call_user_func_array($this->onItem, [$value, $key]);
        }

        return $items;
    }
}

<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Transformers;

use Closure;
use Wrkflow\GetValue\Contracts\TransformerArrayContract;
use Wrkflow\GetValue\GetValue;

/**
 * Re-build the array with a closure for each item
 */
class ArrayItemTransformer implements TransformerArrayContract
{
    /**
     * @param Closure(mixed,string):(array|null) $onItem
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

    public function transform(mixed $value, string $key, GetValue $getValue): ?array
    {
        if (is_array($value) === false) {
            return null;
        }

        $items = [];
        foreach ($value as $index => $item) {
            $items[$index] = call_user_func_array($this->onItem, [$item, $key]);
        }

        return $items;
    }
}

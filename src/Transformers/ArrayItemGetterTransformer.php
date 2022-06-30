<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Transformers;

use Closure;
use Wrkflow\GetValue\Contracts\TransformerArrayContract;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\Exceptions\NotAnArrayException;
use Wrkflow\GetValue\GetValue;

/**
 * Re-build an array with array items that are wrapped within GetValue wrapper
 */
class ArrayItemGetterTransformer implements TransformerArrayContract
{
    /**
     * @param Closure(GetValue,string):array $onItem
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

    /**
     * @param mixed|array<array> $value
     */
    public function transform(mixed $value, string $key, GetValue $getValue): ?array
    {
        if (is_array($value) === false) {
            return null;
        }

        $items = [];
        foreach ($value as $index => $item) {
            if (is_array($item) === false) {
                throw new NotAnArrayException($key . ' at ' . $index);
            }

            $getItemValue = $getValue->makeInstance(new ArrayData($item, $getValue->data->getKey($key)));

            $items[$index] = call_user_func_array($this->onItem, [$getItemValue, $key]);
        }

        return $items;
    }
}

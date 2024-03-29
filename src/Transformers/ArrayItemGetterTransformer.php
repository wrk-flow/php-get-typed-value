<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Transformers;

use Closure;
use Wrkflow\GetValue\Contracts\GetValueTransformerContract;
use Wrkflow\GetValue\DataHolders\AbstractData;
use Wrkflow\GetValue\Exceptions\NotSupportedDataException;
use Wrkflow\GetValue\GetValue;

/**
 * Re-build an array with array items that are wrapped within GetValue wrapper
 */
class ArrayItemGetterTransformer extends AbstractArrayItemTransformer
{
    /**
     * @param Closure(GetValue,string):mixed|GetValueTransformerContract $onItem
     * @param bool                                                       $ignoreNullResult Allows to prevent adding null value to array when
     *                                                         rebuilding an array.
     */
    public function __construct(
        private readonly Closure|GetValueTransformerContract $onItem,
        private readonly bool $beforeValidation = false,
        private readonly bool $ignoreNullResult = true,
    ) {
    }

    public function beforeValidation(mixed $value, string $key): bool
    {
        return $this->beforeValidation;
    }

    protected function transformItem(mixed $item, string $key, string|int $index, GetValue $getValue): mixed
    {
        $fullKey = $key . '.' . $index;
        $data = $getValue->makeData($item, $fullKey);

        if ($data instanceof AbstractData === false) {
            throw new NotSupportedDataException($key . ' at ' . $index);
        }

        $getItemValue = $getValue->makeInstance($data);

        if ($this->onItem instanceof GetValueTransformerContract) {
            return $this->onItem->transform($getItemValue, $fullKey);
        }

        return call_user_func_array($this->onItem, [$getItemValue, $fullKey]);
    }

    protected function ignoreNullResult(): bool
    {
        return $this->ignoreNullResult;
    }
}

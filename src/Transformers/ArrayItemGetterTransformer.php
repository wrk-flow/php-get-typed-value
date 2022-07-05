<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Transformers;

use Closure;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\Exceptions\NotAnArrayException;
use Wrkflow\GetValue\GetValue;

/**
 * Re-build an array with array items that are wrapped within GetValue wrapper
 */
class ArrayItemGetterTransformer extends AbstractArrayItemTransformer
{
    /**
     * @param Closure(GetValue,string):mixed $onItem
     * @param bool                           $beforeValidation
     * @param bool                           $ignoreNullResult Allows to prevent adding null value to array when
     *                                                         rebuilding an array.
     */
    public function __construct(
        private readonly Closure $onItem,
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
        if (is_array($item) === false) {
            throw new NotAnArrayException($key . ' at ' . $index);
        }

        $getItemValue = $getValue->makeInstance(new ArrayData($item, $getValue->data->getKey($key)));

        return call_user_func_array($this->onItem, [$getItemValue, $key]);
    }

    protected function ignoreNullResult(): bool
    {
        return $this->ignoreNullResult;
    }
}

<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Transformers;

use Closure;
use Wrkflow\GetValue\GetValue;

/**
 * Re-build the array with a closure for each item
 */
class ArrayItemTransformer extends AbstractArrayItemTransformer
{
    /**
     * @param Closure(mixed,string):mixed $onItem
     * @param bool                        $ignoreNullResult Allows to prevent adding null value to array when
     *                                                      rebuilding an array.
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
        return call_user_func_array($this->onItem, [$item, $key]);
    }

    protected function ignoreNullResult(): bool
    {
        return $this->ignoreNullResult;
    }
}

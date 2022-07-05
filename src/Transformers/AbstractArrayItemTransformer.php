<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Transformers;

use Wrkflow\GetValue\Contracts\TransformerContract;
use Wrkflow\GetValue\GetValue;

abstract class AbstractArrayItemTransformer implements TransformerContract
{
    public function transform(mixed $value, string $key, GetValue $getValue): mixed
    {
        if (is_array($value) === false) {
            return null;
        }

        $isAssociative = true;
        $items = [];
        $previousIndex = null;
        foreach ($value as $index => $item) {
            $result = $this->transformItem($item, $key, $index, $getValue);

            if (is_int($index) && $isAssociative) {
                if ($previousIndex !== null) {
                    $isAssociative = $previousIndex + 1 === $index;
                }

                $previousIndex = $index;
            } else {
                $isAssociative = false;
            }

            if ($this->ignoreNullResult() && $result === null) {
                continue;
            }

            $items[$index] = $result;
        }

        return $isAssociative ? array_values($items) : $items;
    }

    abstract protected function transformItem(mixed $item, string $key, string|int $index, GetValue $getValue): mixed;

    abstract protected function ignoreNullResult(): bool;
}

<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\DataHolders;

use Wrkflow\GetValue\Enums\ValueType;

class ArrayData extends AbstractData
{
    public function __construct(
        private readonly array $array,
        string $parentKey = ''
    ) {
        parent::__construct($parentKey);
    }

    public function getValue(string|array $key, ValueType $expectedValueType): mixed
    {
        if (is_string($key) && str_contains($key, '.')) {
            $key = explode('.', $key);
        } elseif (is_string($key)) {
            if (array_key_exists($key, $this->array)) {
                return $this->array[$key];
            }

            return null;
        }

        $items = $this->array;

        foreach ($key as $segment) {
            if (is_array($items) === false || array_key_exists($segment, $items) === false) {
                return null;
            }

            $items = $items[$segment];
        }

        return $items;
    }

    public function get(): array
    {
        return $this->array;
    }
}

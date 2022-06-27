<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\DataHolders;

class ArrayData extends AbstractData
{
    public function __construct(private readonly array $array)
    {
    }

    public function getValue(string $key): mixed
    {
        return $this->array[$key] ?? null;
    }

    public function get(): array
    {
        return $this->array;
    }
}

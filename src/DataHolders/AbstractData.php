<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\DataHolders;

use Wrkflow\GetValue\Enums\ValueType;

abstract class AbstractData
{
    public function __construct(
        private readonly string $parentKey = '',
    ) {
    }

    /**
     * @param string|array<int, string> $key
     */
    abstract public function getValue(string|array $key, ValueType $expectedValueType): mixed;

    abstract public function get(): mixed;

    /**
     * Builds full key path with parent key
     *
     * @param string|array<int, string> $key
     */
    public function getKey(string|array $key = ''): string
    {
        if ($key === '') {
            return $this->parentKey;
        }

        $fullKey = is_array($key) ? implode('.', $key) : $key;

        if ($this->parentKey === '') {
            return $fullKey;
        }

        return $this->parentKey . '.' . $fullKey;
    }
}

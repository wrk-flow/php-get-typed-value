<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\DataHolders;

use Wrkflow\GetValue\Enums\ValueType;
use Wrkflow\GetValue\Exceptions\AttributesDotNotationException;
use XMLReader;

final class XMLReaderAttributesData extends AbstractData
{
    public function __construct(
        private readonly XMLReader $reader,
        string $parentKey = '',
    ) {
        parent::__construct($parentKey);
    }

    /**
     * @param string|array<int, string> $key
     */
    public function getValue(string|array $key, ValueType $expectedValueType): ?string
    {
        if (is_array($key)) {
            throw new AttributesDotNotationException(implode('.', $key));
        }

        if (str_contains($key, '.')) {
            throw new AttributesDotNotationException($key);
        }

        return $this->reader->getAttribute($key);
    }

    public function get(): XMLReader
    {
        return $this->reader;
    }
}

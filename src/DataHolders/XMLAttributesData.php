<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\DataHolders;

use SimpleXMLElement;
use Wrkflow\GetValue\Enums\ValueType;
use Wrkflow\GetValue\Exceptions\AttributesDotNotationException;

class XMLAttributesData extends AbstractData
{
    public function __construct(
        private readonly SimpleXMLElement $data,
        string $parentKey = ''
    ) {
        parent::__construct($parentKey);
    }

    public function getValue(string|array $key, ValueType $expectedValueType): ?string
    {
        if (is_array($key)) {
            throw new AttributesDotNotationException(implode('.', $key));
        } elseif (str_contains($key, '.')) {
            throw new AttributesDotNotationException($key);
        }

        $value = $this->data->{$key};

        if ($value instanceof SimpleXMLElement === false) {
            return null;
        }

        return (string) $value;
    }

    public function get(): SimpleXMLElement
    {
        return $this->data;
    }
}

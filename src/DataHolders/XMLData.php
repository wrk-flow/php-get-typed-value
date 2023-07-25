<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\DataHolders;

use SimpleXMLElement;
use Wrkflow\GetValue\Enums\ValueType;

class XMLData extends AbstractData
{
    public function __construct(
        private readonly SimpleXMLElement $data,
        string $parentKey = ''
    ) {
        parent::__construct($parentKey);
    }

    public function getValue(string|array $key, ValueType $expectedValueType): SimpleXMLElement|array|string|null
    {
        if (is_string($key) && str_contains($key, '.')) {
            $key = explode('.', $key);
        } elseif (is_string($key)) {
            $key = [$key];
        }

        $element = $this->data;
        $previousSegmentWasPrefix = false;

        foreach ($key as $segment) {
            $prefixPath = explode(':', (string) $segment);

            if (count($prefixPath) === 2) {
                $element = $element->children(namespaceOrPrefix: $prefixPath[0], isPrefix: true);
                if ($element === null) {
                    return null;
                }
                // When chaining multiple namespaces
                // we cant call $element->children(), children
                // will be called with next segment.
                $previousSegmentWasPrefix = true;
                $segment = $prefixPath[1];
            } elseif ($previousSegmentWasPrefix) {
                // We need to be able to access children in a namespace
                // -> get all of them, so we can use $element->{'KEY'}
                $element = $element->children();
                if ($element === null) {
                    return null;
                }
                $previousSegmentWasPrefix = false;
            }

            // To access an array item at given index we need to cast
            // it to int to SimpleXMLElement to access it.
            $value = is_numeric($segment) ? $element[(int) $segment] : $element->{$segment};

            if ($value === null) {
                return null;
            }

            $element = $value;
        }

        return $this->normalizeValue($expectedValueType, $element);
    }

    public function get(): SimpleXMLElement
    {
        return $this->data;
    }

    protected function normalizeValue(ValueType $valueType, SimpleXMLElement $value): string|array|null|SimpleXMLElement
    {
        if ($valueType === ValueType::Object) {
            if ($value->count() === 0) {
                return null;
            }

            return $value;
        } elseif ($valueType === ValueType::XMLAttributes) {
            return $value;
        } elseif ($valueType === ValueType::Array) {
            $return = [];

            foreach ($value as $val) {
                $return[] = $val;
            }

            return $return;
        } elseif ($value->count() !== 0) {
            return (string) $value;
        }

        return null;
    }
}

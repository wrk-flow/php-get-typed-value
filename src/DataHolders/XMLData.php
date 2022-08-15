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
            $value = $this->data->{$key};

            return $this->normalizeValue($expectedValueType, $value);
        }

        $element = $this->data;

        foreach ($key as $segment) {
            $value = $element->{$segment};

            if ($value->count() === 0) {
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
        if ($valueType === ValueType::XML) {
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

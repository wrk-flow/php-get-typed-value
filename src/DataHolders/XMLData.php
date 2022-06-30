<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\DataHolders;

use SimpleXMLElement;

class XMLData extends AbstractData
{
    public function __construct(
        private readonly SimpleXMLElement $data,
        string $parentKey = ''
    ) {
        parent::__construct($parentKey);
    }

    public function getValue(string|array $key): ?string
    {
        if (is_string($key) && str_contains($key, '.')) {
            $key = explode('.', $key);
        } elseif (is_string($key)) {
            $value = $this->data->{$key};

            if ($value->count() !== 0) {
                return (string) $value;
            }

            return null;
        }

        $element = $this->data;

        foreach ($key as $segment) {
            $value = $element->{$segment};

            if ($value->count() === 0) {
                return null;
            }

            $element = $value;
        }

        return (string) $element;
    }

    public function get(): SimpleXMLElement
    {
        return $this->data;
    }
}

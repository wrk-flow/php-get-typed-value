<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\DataHolders;

use SimpleXMLElement;

class XMLData extends AbstractData
{
    public function __construct(private readonly SimpleXMLElement $data)
    {
    }

    public function getValue(string $key): string
    {
        $value = $this->data->{$key};

        return (string) $value;
    }

    public function get(): SimpleXMLElement
    {
        return $this->data;
    }
}

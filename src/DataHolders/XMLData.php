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

        // TODO figure out how to properly detect "child" exists instead of getting empty string...
        return (string) $value;
    }

    public function get(): SimpleXMLElement
    {
        return $this->data;
    }
}

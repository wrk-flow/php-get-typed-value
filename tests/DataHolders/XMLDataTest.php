<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\DataHolders;

use PHPUnit\Framework\TestCase;
use SimpleXMLElement;
use Wrkflow\GetValue\DataHolders\XMLData;

class XMLDataTest extends TestCase
{
    private SimpleXMLElement $simpleXMLElement;

    private XMLData $data;

    protected function setUp(): void
    {
        parent::setUp();

        $this->simpleXMLElement = new SimpleXMLElement('<root><title>test</title><test attribute="test"/></root>');
        $this->data = new XMLData($this->simpleXMLElement);
    }

    public function testGetReturnsSameInstance(): void
    {
        $this->assertSame($this->simpleXMLElement, $this->data->get());
    }

    public function testEmptyOnNonExistingValue(): void
    {
        $this->assertSame($this->simpleXMLElement, $this->data->get());

        // TODO NULL
        $result = $this->data->getValue('root');
        $this->assertEquals('', $result);
    }

    public function testOnExistingValue(): void
    {
        $result = $this->data->getValue('title');
        $this->assertEquals('test', $result);
    }
}

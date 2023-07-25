<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\DataHolders;

use PHPUnit\Framework\TestCase;
use SimpleXMLElement;
use Wrkflow\GetValue\DataHolders\XMLData;
use Wrkflow\GetValue\Enums\ValueType;

class XMLDataTest extends TestCase
{
    private SimpleXMLElement $simpleXMLElement;

    private XMLData $data;

    protected function setUp(): void
    {
        parent::setUp();

        $this->simpleXMLElement = new SimpleXMLElement(
            <<<'CODE_SAMPLE'
            <root>
                <title>test</title>
                <test attribute="test"/>
                <child>
                    <title>test</title>
                    <val.dot>works in child</val.dot>
                </child>
                <val.dot>works</val.dot>
                <val><dot>works2</dot></val>
                <items>
                <item><value>test</value></item>
                <item><value>test2</value></item>
                </items>
            </root>
            CODE_SAMPLE
        );
        $this->data = new XMLData($this->simpleXMLElement);
    }

    public function testGetReturnsSameInstance(): void
    {
        $this->assertSame($this->simpleXMLElement, $this->data->get());
    }

    public function testEmptyOnNonExistingValue(): void
    {
        $this->assertSame($this->simpleXMLElement, $this->data->get());

        $result = $this->data->getValue('nothing', ValueType::String);
        $this->assertNull($result);
    }

    public function testEmptyOnExistingValue(): void
    {
        $this->assertSame($this->simpleXMLElement, $this->data->get());

        $result = $this->data->getValue('test', ValueType::String);
        $this->assertSame('', $result);
    }

    public function testOnExistingValue(): void
    {
        $result = $this->data->getValue('title', ValueType::String);
        $this->assertSame('test', $result);
    }

    public function testChildWithoutText(): void
    {
        $result = $this->data->getValue('child', ValueType::String);
        $this->assertNotNull($result);
        $this->assertSame('', is_string($result) ? trim($result) : 'no_string');
    }

    public function testChildUsingDotNotationDoesNotExists(): void
    {
        $result = $this->data->getValue('child.test', ValueType::String);
        $this->assertNull($result);
    }

    public function testChildUsingDotNotation(): void
    {
        $result = $this->data->getValue('child.title', ValueType::String);
        $this->assertSame('test', $result);
    }

    public function testDotNotationWithDotForcingAnArrayAtAllCases(): void
    {
        $result = $this->data->getValue('val.dot', ValueType::String);
        $this->assertSame('works2', $result);

        $result = $this->data->getValue(['val', 'dot'], ValueType::String);
        $this->assertSame('works2', $result);

        $result = $this->data->getValue(['val.dot'], ValueType::String);
        $this->assertSame('works', $result);

        $result = $this->data->getValue('child.val.dot', ValueType::String);
        $this->assertNull($result);
    }

    public function testArrayAccess(): void
    {
        $this->assertEquals(
            expected: 'test',
            actual: $this->data->getValue(['items', 'item', '0', 'value'], ValueType::String),
        );

        $this->assertEquals(
            expected: 'test2',
            actual: $this->data->getValue(['items', 'item', '1', 'value'], ValueType::String),
        );
    }
}

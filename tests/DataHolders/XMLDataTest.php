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

        $result = $this->data->getValue('nothing');
        $this->assertNull($result);
    }

    public function testEmptyOnExistingValue(): void
    {
        $this->assertSame($this->simpleXMLElement, $this->data->get());

        $result = $this->data->getValue('test');
        $this->assertSame('', $result);
    }

    public function testOnExistingValue(): void
    {
        $result = $this->data->getValue('title');
        $this->assertSame('test', $result);
    }

    public function testChildWithoutText(): void
    {
        $result = $this->data->getValue('child');
        $this->assertNotNull($result);
        $this->assertSame('', trim($result));
    }

    public function testChildUsingDotNotationDoesNotExists(): void
    {
        $result = $this->data->getValue('child.test');
        $this->assertNull($result);
    }

    public function testChildUsingDotNotation(): void
    {
        $result = $this->data->getValue('child.title');
        $this->assertSame('test', $result);
    }

    public function testDotNotationWithDotForcingAnArrayAtAllCases(): void
    {
        $result = $this->data->getValue('val.dot');
        $this->assertSame('works2', $result);

        $result = $this->data->getValue(['val', 'dot']);
        $this->assertSame('works2', $result);

        $result = $this->data->getValue(['val.dot']);
        $this->assertSame('works', $result);

        $result = $this->data->getValue('child.val.dot');
        $this->assertNull($result);
    }
}

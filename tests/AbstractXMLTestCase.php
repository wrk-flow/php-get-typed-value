<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests;

use PHPUnit\Framework\TestCase;
use SimpleXMLElement;
use Wrkflow\GetValue\DataHolders\XMLData;
use Wrkflow\GetValue\GetValue;

abstract class AbstractXMLTestCase extends TestCase
{
    final public const KeyTitle = 'title';

    final public const KeyItems = 'rates';

    final public const KeyRate = 'rate';

    final public const KeyObject = 'object';

    final public const KeyValueWithAttributes = 'attribute';

    protected GetValue $data;

    protected XMLData $xmlData;

    protected function setUp(): void
    {
        parent::setUp();

        $this->xmlData = new XMLData(new SimpleXMLElement(
            <<<'CODE_SAMPLE'
<root>
    <title>test</title>
    <attribute test="value">test</attribute>
    <rates>
        <rate><name>Marco</name></rate>
        <rate><name>Polo</name></rate>
    </rates>
    <object>
        <type>x</type>
        <number>1</number>
        <child>
            <title>test</title>
        </child>
    </object>
</root>
CODE_SAMPLE
        ));

        $this->data = new GetValue($this->xmlData);
    }
}

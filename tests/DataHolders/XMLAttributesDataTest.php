<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\DataHolders;

use PHPUnit\Framework\TestCase;
use SimpleXMLElement;
use Wrkflow\GetValue\DataHolders\XMLAttributesData;
use Wrkflow\GetValue\Enums\ValueType;
use Wrkflow\GetValue\Exceptions\AttributesDotNotationException;

class XMLAttributesDataTest extends TestCase
{
    public XMLAttributesData $data;

    private SimpleXMLElement $attributes;

    protected function setUp(): void
    {
        parent::setUp();
        $xml = new SimpleXMLElement('<root key="test" />');
        $attributes = $xml->attributes();
        $this->assertNotNull($attributes);
        $this->attributes = $attributes;
        $this->data = new XMLAttributesData($this->attributes);
    }

    public function testAttributesDotNotationNotSupported(): void
    {
        $this->expectException(AttributesDotNotationException::class);
        $this->data->getValue(['test', 'test2'], ValueType::String);
    }

    public function testAttributesDotNotationNotSupportedString(): void
    {
        $this->expectException(AttributesDotNotationException::class);
        $this->data->getValue('test.key', ValueType::String);
    }

    public function testUnknownAttribute(): void
    {
        $this->assertNull($this->data->getValue('unknown', ValueType::String));
    }

    public function testGetValue(): void
    {
        $this->assertEquals('test', $this->data->getValue('key', ValueType::String));
    }

    public function testGet(): void
    {
        $this->assertNotNull($this->attributes);
        $this->assertSame($this->attributes, $this->data->get());
    }
}

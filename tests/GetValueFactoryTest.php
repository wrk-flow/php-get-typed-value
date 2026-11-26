<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests;

use PHPUnit\Framework\TestCase;
use SimpleXMLElement;
use Wrkflow\GetValue\Exceptions\AttributesDotNotationException;
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\GetValueFactory;
use Wrkflow\GetValue\Strategies\NoTransformerStrategy;
use Wrkflow\GetValueTests\Builders\CustomExceptionBuilder;
use XMLReader;

class GetValueFactoryTest extends TestCase
{
    private GetValueFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->factory = new GetValueFactory();
    }

    public function testCustomStrategyAndException(): void
    {
        $this->factory = new GetValueFactory(
            transformerStrategy: new NoTransformerStrategy(),
            exceptionBuilder: new CustomExceptionBuilder(),
        );

        $getValue = $this->createArray();

        $this->assertEquals('This is a test', $getValue->getRequiredString('test'));
        $this->assertEquals('', $getValue->getRequiredString('default_transform_string'));
        $this->expectExceptionMessage('missingValue: no_value');
        $getValue->getRequiredString('no_value');
    }

    public function testXML(): void
    {
        $getValue = $this->factory->xml(new SimpleXMLElement('<root><test>This is a test</test></root>'));

        $this->assertEquals('This is a test', $getValue->getRequiredString('test'));
    }

    public function testXMLReaderAttributesUseTypedGettersWithoutMovingTheReader(): void
    {
        $reader = XMLReader::XML('<item cod="  A1  " maxp=" 4 " xmlns:m="urn:meta" m:label="house"/>');
        self::assertInstanceOf(XMLReader::class, $reader);
        self::assertTrue($reader->read());

        $attributes = $this->factory->xmlReaderAttributes($reader, 'item');

        self::assertSame('A1', $attributes->getRequiredString('cod'));
        self::assertSame(4, $attributes->getRequiredInt('maxp'));
        self::assertSame('house', $attributes->getRequiredString('m:label'));
        self::assertNull($attributes->getString('missing'));
        self::assertSame($reader, $attributes->data->get());
        self::assertSame(XMLReader::ELEMENT, $reader->nodeType);
        self::assertSame('item.missing', $attributes->data->getKey('missing'));

        $this->expectException(AttributesDotNotationException::class);
        $attributes->getString('item.cod');
    }

    public function testArray(): void
    {
        $getValue = $this->createArray();

        $this->assertEquals('This is a test', $getValue->getRequiredString('test'));
        $this->assertEquals(null, $getValue->getString('default_transform_string'));
        $this->expectExceptionMessage('Data is missing a value for a key <no_value>');
        $getValue->getRequiredString('no_value');
    }

    protected function createArray(): GetValue
    {
        return $this->factory->array([
            'test' => 'This is a test',
            'default_transform_string' => '',
        ]);
    }
}

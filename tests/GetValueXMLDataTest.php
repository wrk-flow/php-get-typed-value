<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests;

use SimpleXMLElement;
use Wrkflow\GetValue\Actions\GetValidatedValueAction;
use Wrkflow\GetValue\Builders\ExceptionBuilder;
use Wrkflow\GetValue\DataHolders\XMLData;
use Wrkflow\GetValue\Exceptions\MissingValueForKeyException;
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\Strategies\DefaultTransformerStrategy;

class GetValueXMLDataTest extends AbstractXMLTestCase
{
    public function testOpinionatedConstructor(): void
    {
        $this->assertInstanceOf(DefaultTransformerStrategy::class, $this->data->transformerStrategy);
        $this->assertInstanceOf(ExceptionBuilder::class, $this->data->exceptionBuilder);
        $this->assertInstanceOf(GetValidatedValueAction::class, $this->data->getValidatedValueAction);
    }

    public function testXMLArrayAccess(): void
    {
        $expectedMap = ['Marco', 'Polo'];

        $index = 0;
        foreach ($this->data->getRequiredXML('rates.rate') as $rate) {
            /** @var SimpleXMLElement $rate */
            $rateData = new GetValue(new XMLData($rate));

            $this->assertEquals($expectedMap[$index], $rateData->getString('name'));
            ++$index;
        }
    }

    public function testGetRequiredXMLGetter(): void
    {
        $object = $this->data->getRequiredXMLGetter(self::KeyObject);

        $this->assertObject($object);
    }

    public function testGetRequiredXMLGetterNonExists(): void
    {
        $this->expectException(MissingValueForKeyException::class);
        $this->expectExceptionMessage('Data is missing a value for a key <non_exists>');

        $this->data->getRequiredXMLGetter('non_exists');
    }

    public function testAttributes(): void
    {
        $this->assertEquals('test', $this->data->getRequiredString(self::KeyValueWithAttributes));

        $attributes = $this->data->getXMLAttributesGetter(self::KeyValueWithAttributes);

        $this->assertEquals('value', $attributes->getRequiredString('test'));
    }

    public function testAttributesOnEntryWithoutAttributes(): void
    {
        $this->assertEquals('test', $this->data->getRequiredString(self::KeyTitle));

        $attributes = $this->data->getXMLAttributesGetter(self::KeyTitle);

        $this->expectExceptionMessage('Data is missing a value for a key <title.@attributes.test>');
        $attributes->getRequiredString('test');
    }

    public function testGetNullableGetter(): void
    {
        $object = $this->data->getNullableXMLGetter(self::KeyObject);

        $this->assertNotNull($object);
        $this->assertObject($object);

        $this->assertNull($this->data->getNullableXMLGetter('not_exists'));
    }

    public function testGetXMLGetter(): void
    {
        $object = $this->data->getXMLGetter(self::KeyObject);

        $this->assertObject($object);
        $this->assertNotNull($this->data->getXMLGetter('not_exists'));
    }

    protected function assertObject(GetValue $object): void
    {
        $this->assertEquals('x', $object->getRequiredString('type'));
        $this->assertEquals(1, $object->getRequiredInt('number'));
        $this->assertEquals(null, $object->getInt('number2'));
        $child = $object->getRequiredXMLGetter('child');

        $this->assertEquals('test', $child->getRequiredString(self::KeyTitle));
        $this->assertEquals(null, $child->getString('title2'));
    }
}

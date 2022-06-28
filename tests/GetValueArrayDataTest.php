<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests;

use Wrkflow\GetValue\Actions\GetValidatedValueAction;
use Wrkflow\GetValue\Builders\ExceptionBuilder;
use Wrkflow\GetValue\Exceptions\ArrayIsEmptyException;
use Wrkflow\GetValue\Exceptions\NotAnArrayException;
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\Strategies\DefaultTransformerStrategy;

class GetValueArrayDataTest extends AbstractArrayTestCase
{
    public function testOpinionatedConstructor(): void
    {
        $this->assertInstanceOf(DefaultTransformerStrategy::class, $this->data->transformerStrategy);
        $this->assertInstanceOf(ExceptionBuilder::class, $this->data->exceptionBuilder);
        $this->assertInstanceOf(GetValidatedValueAction::class, $this->data->getValidatedValueAction);
    }

    public function testGetRequiredArrayGetter(): void
    {
        $items = $this->data->getRequiredArrayGetter(self::KeyItems);

        $this->assertItems($items);
    }

    public function testGetArrayGetter(): void
    {
        $items = $this->data->getArrayGetter(self::KeyItems);

        $this->assertNotNull($items);

        $this->assertItems($items);
    }

    public function testGetRequiredArrayGetterOnNonArray(): void
    {
        $this->expectException(NotAnArrayException::class);

        $this->data->getRequiredArrayGetter(self::KeyEmail);
    }

    public function testGetRequiredArrayGetterOnEmptyArray(): void
    {
        $this->expectException(ArrayIsEmptyException::class);

        $this->data->getRequiredArrayGetter(self::KeyItemsEmpty);
    }

    public function testGetRequiredArrayGetterOnNonExistingItem(): void
    {
        $this->expectException(ArrayIsEmptyException::class);

        $this->data->getRequiredArrayGetter('test');
    }

    public function testGetArrayGetterOnNonArray(): void
    {
        $this->expectException(NotAnArrayException::class);

        $this->data->getArrayGetter(self::KeyEmail);
    }

    public function testGetArrayGetterOnNonExistingItem(): void
    {
        $result = $this->data->getArrayGetter('');
        $this->assertInstanceOf(GetValue::class, $result);
        $this->assertEmpty($result->data->get());
    }

    public function testGetArrayGetterOnEmptyArray(): void
    {
        $result = $this->data->getArrayGetter(self::KeyItemsEmpty);
        $this->assertInstanceOf(GetValue::class, $result);
        $this->assertEmpty($result->data->get());

        $this->assertSame($this->data->transformerStrategy, $result->transformerStrategy);
        $this->assertSame($this->data->exceptionBuilder, $result->exceptionBuilder);
        $this->assertSame($this->data->getValidatedValueAction, $result->getValidatedValueAction);
    }

    public function testGetNullableArrayGetter(): void
    {
        $result = $this->data->getNullableArrayGetter(self::KeyItems);
        $this->assertInstanceOf(GetValue::class, $result);
        $this->assertCount(2, $result->data->get());
    }

    public function testGetNullableArrayGetterOnNonExistingItem(): void
    {
        $this->assertNull($this->data->getNullableArrayGetter(''));
    }

    public function testGetNullableArrayGetterOnEmptyArray(): void
    {
        $this->assertNull($this->data->getNullableArrayGetter(self::KeyItemsEmpty));
    }

    protected function assertItem(
        GetValue $item,
        string $expectedName,
        ?string $expectedLabel,
        array $expectedTags
    ): void {
        $name = $item->getRequiredString(self::KeyItemName);
        $this->assertEquals($expectedName, $name);

        $tags = $item->getArray(self::KeyTags);
        $this->assertEquals($expectedTags, $tags);

        $label = $item->getString(self::KeyItemLabel);
        $this->assertEquals($expectedLabel, $label);
    }

    protected function assertItems(GetValue $items): void
    {
        $this->assertEquals(1, $this->data->getRequiredInt(self::KeyPage));
        $this->assertCount(2, $items->data->get());

        $item = $items->getRequiredArrayGetter('0');

        $this->assertItem(item: $item, expectedName: 'test', expectedLabel: 'yes', expectedTags: []);

        $item = $items->getRequiredArrayGetter('1');

        $this->assertItem(item: $item, expectedName: 'test 2', expectedLabel: null, expectedTags: ['test']);
    }
}

<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests;

use Wrkflow\GetValue\Exceptions\ArrayIsEmptyException;
use Wrkflow\GetValue\GetValue;

class GetValueArrayDataWithArrayTest extends AbstractArrayTestCase
{
    public function requiredData(): array
    {
        return [
            self::KeyNull . ' throws exception' => [self::KeyNull, null, ArrayIsEmptyException::class],
            self::KeyEmpty . ' throws exception' => [self::KeyEmpty, null, ArrayIsEmptyException::class],
            self::KeyValid . ' returns value' => [self::KeyValid, ['test']],
            self::KeyMissingValue . ' throws exception' => [self::KeyMissingValue, null, ArrayIsEmptyException::class],
        ];
    }

    /**
     * @dataProvider requiredData
     */
    public function testRequired(string $key, mixed $expectedValue = null, ?string $expectedException = null): void
    {
        $data = $this->getBaseData($expectedException, $key);

        $value = $data->getRequiredArray(self::KeyTags);

        if ($expectedException === null) {
            $this->assertEquals($expectedValue, $value);
        }
    }

    public function nullableArrayData(): array
    {
        return [
            self::KeyNull . ' returns value' => [self::KeyNull, null],
            self::KeyEmpty . ' returns value' => [self::KeyEmpty, []],
            self::KeyValid . ' returns value' => [self::KeyValid, ['test']],
            self::KeyMissingValue . ' is converted to null' => [self::KeyMissingValue, null],
        ];
    }

    /**
     * @dataProvider nullableArrayData
     */
    public function testNullableArray(string $key, mixed $expectedValue = null, ?string $expectedException = null): void
    {
        $data = $this->getBaseData($expectedException, $key);

        $value = $data->getNullableArray(self::KeyTags);

        if ($expectedException === null) {
            $this->assertEquals($expectedValue, $value);
        }
    }

    public function arrayData(): array
    {
        return [
            self::KeyNull . ' is converted to array' => [self::KeyNull, []],
            self::KeyEmpty . ' returns value' => [self::KeyEmpty, []],
            self::KeyValid . ' returns value' => [self::KeyValid, ['test']],
            self::KeyMissingValue . ' is converted to array' => [self::KeyMissingValue, []],
        ];
    }

    /**
     * @dataProvider arrayData
     */
    public function testArray(string $key, mixed $expectedValue = null, ?string $expectedException = null): void
    {
        $data = $this->getBaseData($expectedException, $key);

        $value = $data->getArray(self::KeyTags);

        if ($expectedException === null) {
            $this->assertEquals($expectedValue, $value);
        }
    }

    protected function getBaseData(?string $expectedException, string $key): GetValue
    {
        if ($expectedException !== null) {
            $this->expectException(ArrayIsEmptyException::class);
        }

        return $this->data->getRequiredArrayGetter($key);
    }
}

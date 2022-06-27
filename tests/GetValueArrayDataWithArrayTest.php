<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests;

use Wrkflow\GetValue\Exceptions\AbstractGetValueException;
use Wrkflow\GetValue\Exceptions\ArrayIsEmptyException;
use Wrkflow\GetValue\Exceptions\NotAnArrayException;
use Wrkflow\GetValue\GetValue;

class GetValueArrayDataWithArrayTest extends AbstractArrayTestsTestCase
{
    public function requiredData(): array
    {
        return [
            self::KeyNull . ' throws exception' => [self::KeyNull, null, ArrayIsEmptyException::class],
            self::KeyEmpty . ' throws exception' => [self::KeyEmpty, null, ArrayIsEmptyException::class],
            self::KeyValid . ' returns value' => [self::KeyValid, ['test']],
            self::KeyInvalid . ' returns value' => [self::KeyInvalid, null, NotAnArrayException::class],
            self::KeyMissingValue . ' throws exception' => [self::KeyMissingValue, null, ArrayIsEmptyException::class],
        ];
    }

    public function optionalData(): array
    {
        return [
            self::KeyNull . ' is converted to array' => [self::KeyNull, []],
            self::KeyEmpty . ' returns value' => [self::KeyEmpty, []],
            self::KeyInvalid . ' returns value' => [self::KeyInvalid, null, NotAnArrayException::class],
            self::KeyValid . ' returns value' => [self::KeyValid, ['test']],
            self::KeyMissingValue . ' is converted to array' => [self::KeyMissingValue, []],
        ];
    }

    public function nullableArrayData(): array
    {
        return [
            self::KeyNull . ' returns value' => [self::KeyNull, null],
            self::KeyEmpty . ' returns value' => [self::KeyEmpty, []],
            self::KeyInvalid . ' returns value' => [self::KeyInvalid, null, NotAnArrayException::class],
            self::KeyValid . ' returns value' => [self::KeyValid, ['test']],
            self::KeyMissingValue . ' is converted to null' => [self::KeyMissingValue, null],
        ];
    }

    /**
     * @dataProvider nullableArrayData
     * @param class-string<AbstractGetValueException>|null $expectedException
     */
    public function testNullableArray(string $key, mixed $expectedValue = null, ?string $expectedException = null): void
    {
        $data = $this->getBaseData($expectedException, $key);

        $value = $data->getNullableArray(self::KeyTags);

        if ($expectedException === null) {
            $this->assertEquals($expectedValue, $value);
        }
    }

    protected function getRequiredValue(GetValue $data, array $rules): mixed
    {
        return $data->getRequiredArray(self::KeyTags);
    }

    protected function getOptionalValue(GetValue $data, array $rules): mixed
    {
        return $data->getArray(self::KeyTags);
    }
}

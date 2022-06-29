<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests;

use Wrkflow\GetValue\Exceptions\MissingValueForKeyException;
use Wrkflow\GetValue\Exceptions\ValidationFailedException;
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\Rules\IpRule;
use Wrkflow\GetValueTests\Enums\EnumInt;

class GetValueArrayDataWithEnumIntTest extends AbstractArrayTestsTestCase
{
    public function requiredData(): array
    {
        return [
            self::KeyNull . ' throws exception' => [self::KeyNull, null, MissingValueForKeyException::class],
            self::KeyEmpty . ' throws exception' => [self::KeyEmpty, null, MissingValueForKeyException::class],
            self::KeyInvalid . ' throws exception because array is not string' => [
                self::KeyInvalid,
                null,
                ValidationFailedException::class,
            ],
            self::KeyValid . ' returns value' => [self::KeyValid, EnumInt::Test],
            self::KeyValid . ' but fails validation' => [
                self::KeyValid,
                null,
                ValidationFailedException::class,
                [new IpRule()], ],
            self::KeyMissingValue . ' throws exception' => [
                self::KeyMissingValue,
                null,
                MissingValueForKeyException::class,
            ],
        ];
    }

    public function optionalData(): array
    {
        return [
            self::KeyNull . ' is converted to array' => [self::KeyNull, null],
            self::KeyEmpty . ' throws exception' => [self::KeyEmpty, null],
            self::KeyInvalid . ' throws exception because array is not string' => [
                self::KeyInvalid,
                null,
                ValidationFailedException::class,
            ],
            self::KeyValid . ' returns value' => [self::KeyValid, EnumInt::Test],
            self::KeyValid . ' but fails validation' => [
                self::KeyValid,
                null,
                ValidationFailedException::class,
                [new IpRule()], ],
            self::KeyMissingValue . ' is converted to array' => [self::KeyMissingValue, null],
        ];
    }

    public function noStrategyData(): array
    {
        return [
            self::KeyNull . ' is converted to array' => [self::KeyNull, null],
            self::KeyEmpty . ' throws an exception because empty string is not valid enum' => [
                self::KeyEmpty,
                null,
                ValidationFailedException::class,
            ],
            self::KeyInvalid . ' throws exception because array is not string' => [
                self::KeyInvalid,
                null,
                ValidationFailedException::class,
            ],
            self::KeyValid . ' returns value' => [self::KeyValid, EnumInt::Test],
            self::KeyValid . ' but fails validation' => [
                self::KeyValid,
                null,
                ValidationFailedException::class,
                [new IpRule()], ],
            self::KeyMissingValue . ' is converted to array' => [self::KeyMissingValue, null],
        ];
    }

    public function testDisableTransformers(): void
    {
        $result = $this->data->getRequiredArrayGetter(self::KeyNull)
            ->getEnum(self::KeyEnumInt, enum: EnumInt::class, transformers: []);

        $this->assertNull($result);
    }

    protected function getRequiredValue(GetValue $data, array $rules): mixed
    {
        return $data->getRequiredEnum(self::KeyEnumInt, enum: EnumInt::class, rules: $rules);
    }

    protected function getOptionalValue(GetValue $data, array $rules): mixed
    {
        return $data->getEnum(self::KeyEnumInt, enum: EnumInt::class, rules: $rules);
    }
}

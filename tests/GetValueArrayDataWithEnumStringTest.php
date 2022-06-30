<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests;

use Wrkflow\GetValue\Exceptions\MissingValueForKeyException;
use Wrkflow\GetValue\Exceptions\ValidationFailedException;
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\Rules\IntegerRule;
use Wrkflow\GetValue\Rules\IpRule;
use Wrkflow\GetValueTests\Enums\EnumString;

class GetValueArrayDataWithEnumStringTest extends AbstractArrayTestsTestCase
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
            self::KeyValid . ' returns value' => [self::KeyValid, EnumString::Test],
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
            self::KeyValid . ' returns value' => [self::KeyValid, EnumString::Test],
            self::KeyValid . ' but fails validation' => [
                self::KeyValid,
                null,
                ValidationFailedException::class,
                [new IntegerRule()], ],
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
            self::KeyValid . ' returns value' => [self::KeyValid, EnumString::Test],
            self::KeyValid . ' but fails validation' => [
                self::KeyValid,
                null,
                ValidationFailedException::class,
                [new IntegerRule()], ],
            self::KeyMissingValue . ' is converted to array' => [self::KeyMissingValue, null],
        ];
    }

    public function testDisableTransformers(): void
    {
        $result = $this->data->getRequiredArrayGetter(self::KeyNull)
            ->getEnum(self::KeyEnum, enum: EnumString::class, transformers: []);

        $this->assertNull($result);
    }

    public function testDotNotation(): void
    {
        $path = [self::KeyItems, '0', self::KeyEnum];
        $this->assertEquals(EnumString::Test, $this->data->getEnum($path, EnumString::class));
        $this->assertEquals(EnumString::Test, $this->data->getEnum(implode('.', $path), EnumString::class));
    }

    public function testDotNotationNotAnArray(): void
    {
        $path = [self::KeyItems, '0'];
        $this->expectExceptionMessage('Validation failed for <items.0> key. Reason: StringRule failed');
        $this->data->getEnum($path, EnumString::class);
    }

    protected function getRequiredValue(GetValue $data, array $rules): mixed
    {
        return $data->getRequiredEnum(self::KeyEnum, enum: EnumString::class, rules: $rules);
    }

    protected function getOptionalValue(GetValue $data, array $rules): mixed
    {
        return $data->getEnum(self::KeyEnum, enum: EnumString::class, rules: $rules);
    }
}

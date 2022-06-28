<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests;

use Wrkflow\GetValue\Exceptions\MissingValueForKeyException;
use Wrkflow\GetValue\Exceptions\ValidationFailedException;
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\Rules\IntegerRule;
use Wrkflow\GetValue\Rules\IpRule;

class GetValueArrayDataWithStringTest extends AbstractArrayTestsTestCase
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
            self::KeyValid . ' returns value' => [self::KeyValid, 'martin@kluska.cz'],
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
            self::KeyValid . ' returns value' => [self::KeyValid, 'martin@kluska.cz'],
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
            self::KeyEmpty . ' does not transform empty string' => [self::KeyEmpty, ''],
            self::KeyInvalid . ' throws exception because array is not string' => [
                self::KeyInvalid,
                null,
                ValidationFailedException::class,
            ],
            self::KeyValid . ' returns value' => [self::KeyValid, 'martin@kluska.cz'],
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
        $result = $this->data->getRequiredArrayGetter(self::KeyEmpty)
            ->getString(self::KeyEmail, transformers: []);

        $this->assertSame('', $result);
    }

    protected function getRequiredValue(GetValue $data, array $rules): mixed
    {
        return $data->getRequiredString(self::KeyEmail, $rules);
    }

    protected function getOptionalValue(GetValue $data, array $rules): mixed
    {
        return $data->getString(self::KeyEmail, $rules);
    }
}

<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests;

use Wrkflow\GetValue\Exceptions\MissingValueForKeyException;
use Wrkflow\GetValue\Exceptions\ValidationFailedException;
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\Rules\EmailRule;
use Wrkflow\GetValue\Rules\IpRule;
use Wrkflow\GetValue\Rules\MaxRule;
use Wrkflow\GetValue\Rules\MinRule;

class GetValueArrayDataWithBoolTest extends AbstractArrayTestsTestCase
{
    public function requiredData(): array
    {
        return [
            self::KeyNull . ' throws exception' => [self::KeyNull, null, MissingValueForKeyException::class],
            self::KeyEmpty . ' string throws exception' => [self::KeyEmpty, null, ValidationFailedException::class],
            self::KeyInvalid . ' throws exception because array is not string' => [
                self::KeyInvalid,
                null,
                ValidationFailedException::class,
            ],
            self::KeyValid . ' returns value' => [self::KeyValid, true],
            self::KeyValid . ' returns value with min max rules that converts bool to int' => [
                self::KeyValid,
                true,
                null,
                [new MinRule(0), new MaxRule(1)], ],
            self::KeyValid . ' throws exception if min/max rule failed' => [
                self::KeyValid,
                null,
                ValidationFailedException::class,
                [new MinRule(5), new MaxRule(8)], ],
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
            self::KeyEmpty . ' string throws exception' => [self::KeyEmpty, null, ValidationFailedException::class],
            self::KeyInvalid . ' throws exception because array is not string' => [
                self::KeyInvalid,
                null,
                ValidationFailedException::class,
            ],
            self::KeyValid . ' returns value' => [self::KeyValid, true],
            self::KeyValid . ' returns value with min max rules that converts bool to int' => [
                self::KeyValid,
                true,
                null,
                [new MinRule(0), new MaxRule(1)],
            ],
            self::KeyValid . ' throws exception if min/max rule failed' => [
                self::KeyValid,
                null,
                ValidationFailedException::class,
                [new MinRule(5), new MaxRule(8)],
            ],
            self::KeyValid . ' but fails validation' => [
                self::KeyValid,
                null,
                ValidationFailedException::class,
                [new EmailRule()],
            ],
            self::KeyMissingValue . ' is converted to array' => [self::KeyMissingValue, null],
        ];
    }

    public function noStrategyData(): array
    {
        return $this->optionalData();
    }

    public function testDisableTransformers(): void
    {
        $this->expectException(ValidationFailedException::class);

        $this->data->getBool(self::KeyBoolInString, transformers: []);
    }

    public function testTransformBoolWithRule(): void
    {
        $result = $this->data->getBool(self::KeyBoolInString);

        $this->assertTrue($result);
    }

    protected function getRequiredValue(GetValue $data, array $rules): mixed
    {
        return $data->getRequiredBool(self::KeyIsActive, $rules);
    }

    protected function getOptionalValue(GetValue $data, array $rules): mixed
    {
        return $data->getBool(self::KeyIsActive, $rules);
    }
}

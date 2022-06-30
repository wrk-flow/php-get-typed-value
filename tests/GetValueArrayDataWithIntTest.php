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

class GetValueArrayDataWithIntTest extends AbstractArrayTestsTestCase
{
    public function requiredData(): array
    {
        return [
            self::KeyNull . ' throws exception' => [self::KeyNull, null, MissingValueForKeyException::class],
            self::KeyEmpty . ' string throws exception' => [self::KeyEmpty, null, ValidationFailedException::class],
            self::KeyInvalid . ' throws exception because a string' => [
                self::KeyInvalid,
                null,
                ValidationFailedException::class,
            ],
            self::KeyValid . ' returns value' => [self::KeyValid, 10],
            self::KeyValid . ' returns value with min max rules' => [
                self::KeyValid,
                10,
                null,
                [new MinRule(5), new MaxRule(12)], ],
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
            self::KeyValid . ' returns value' => [self::KeyValid, 10],
            self::KeyValid . ' returns value with min max rules' => [
                self::KeyValid,
                10,
                null,
                [new MinRule(5), new MaxRule(12)], ],
            self::KeyValid . ' throws exception if min/max rule failed' => [
                self::KeyValid,
                10,
                ValidationFailedException::class,
                [new MinRule(5), new MaxRule(8)], ],
            self::KeyValid . ' but fails validation' => [
                self::KeyValid,
                null,
                ValidationFailedException::class,
                [new EmailRule()], ],
            self::KeyMissingValue . ' is converted to array' => [self::KeyMissingValue, null],
        ];
    }

    public function noStrategyData(): array
    {
        return $this->optionalData();
    }

    public function testStringInt(): void
    {
        $this->assertEquals(1, $this->data->getInt(self::KeyPageString));
    }

    public function testDotNotation(): void
    {
        $path = [self::KeyItems, '0', self::KeyPage];
        $this->assertEquals(1, $this->data->getInt($path));
        $this->assertEquals(1, $this->data->getInt(implode('.', $path)));
    }

    public function testDotNotationNotAnArray(): void
    {
        $path = [self::KeyItems, '0'];
        $this->expectExceptionMessage('Validation failed for <items.0> key. Reason: NumericRule failed');
        $this->data->getInt($path);
    }

    protected function getRequiredValue(GetValue $data, array $rules): mixed
    {
        return $data->getRequiredInt(self::KeyPage, $rules);
    }

    protected function getOptionalValue(GetValue $data, array $rules): mixed
    {
        return $data->getInt(self::KeyPage, $rules);
    }
}

<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests;

use DateTime;
use Exception;
use Wrkflow\GetValue\Exceptions\MissingValueForKeyException;
use Wrkflow\GetValue\Exceptions\ValidationFailedException;
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\Rules\EmailRule;
use Wrkflow\GetValue\Rules\IpRule;
use Wrkflow\GetValue\Rules\MaxRule;
use Wrkflow\GetValue\Rules\MinRule;

class GetValueArrayDataWithDateTimeTest extends AbstractArrayTestsTestCase
{
    public function requiredData(): array
    {
        return [
            self::KeyNull . ' throws exception' => [self::KeyNull, null, MissingValueForKeyException::class],
            self::KeyEmpty . ' string throws exception' => [self::KeyEmpty, null, MissingValueForKeyException::class],
            self::KeyInvalid . ' throws exception because not valid date time' => [
                self::KeyInvalid,
                null,
                Exception::class,
            ],
            self::KeyValid . ' returns value' => [self::KeyValid, new DateTime('2022-02-02 23:22:21')],
            self::KeyValid . ' throws with min max rules that does not support date time' => [
                self::KeyValid,
                null,
                ValidationFailedException::class,
                [new MinRule(5), new MaxRule(12)], ],
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
            self::KeyEmpty . ' string return null' => [self::KeyEmpty, null],
            self::KeyInvalid . ' throws exception because it is not valid date time' => [
                self::KeyInvalid,
                null,
                Exception::class,
            ],
            self::KeyValid . ' returns value' => [self::KeyValid, new DateTime('2022-02-02 23:22:21')],
            self::KeyValid . ' throws with min max rules that does not support date time' => [
                self::KeyValid,
                null,
                ValidationFailedException::class,
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
                [new EmailRule()], ],
            self::KeyMissingValue . ' is converted to array' => [self::KeyMissingValue, null],
        ];
    }

    public function testDateTimeWithArrayFails(): void
    {
        $this->expectException(ValidationFailedException::class);
        $this->data->getDateTime(self::KeyItems);
    }

    protected function getRequiredValue(GetValue $data, array $rules): mixed
    {
        return $data->getRequiredDateTime(self::KeyUpdatedAt, $rules);
    }

    protected function getOptionalValue(GetValue $data, array $rules): mixed
    {
        return $data->getDateTime(self::KeyUpdatedAt, $rules);
    }
}

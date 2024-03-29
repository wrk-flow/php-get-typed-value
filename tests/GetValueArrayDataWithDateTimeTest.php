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
use Wrkflow\GetValue\Transformers\ClosureTransformer;
use Wrkflow\GetValue\Transformers\TrimAndEmptyStringToNull;

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
            self::KeyValid . ' returns value' => [self::KeyValid, $this->getDateTime()],
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
            self::KeyValid . ' returns value' => [self::KeyValid, $this->getDateTime()],
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

    public function noStrategyData(): array
    {
        return [
            self::KeyNull . ' is converted to array' => [self::KeyNull, null],
            self::KeyEmpty . ' string return null' => [self::KeyEmpty, null, ValidationFailedException::class],
            self::KeyInvalid . ' throws exception because it is not valid date time' => [
                self::KeyInvalid,
                null,
                Exception::class,
            ],
            self::KeyValid . ' returns value' => [self::KeyValid, $this->getDateTime()],
            self::KeyValid . ' throws with min max rules that does not support date time' => [
                self::KeyValid,
                null,
                ValidationFailedException::class,
                [new MinRule(5), new MaxRule(12)],
            ],
            self::KeyValid . ' throws exception if min/max rule failed' => [
                self::KeyValid,
                null,
                ValidationFailedException::class,
                [new MinRule(5), new MaxRule(8)], ],
            self::KeyValid . ' but fails validation' => [
                self::KeyValid,
                null,
                ValidationFailedException::class,
                [new EmailRule()],
            ],
            self::KeyMissingValue . ' is converted to array' => [self::KeyMissingValue, null],
        ];
    }

    public function testDateTimeWithArrayFails(): void
    {
        $this->expectException(ValidationFailedException::class);
        $this->data->getDateTime(self::KeyItems);
    }

    public function testDotNotation(): void
    {
        $path = [self::KeyItems, '0', self::KeyUpdatedAt];
        $this->assertEquals($this->getDateTime(), $this->data->getDateTime($path));
        $this->assertEquals($this->getDateTime(), $this->data->getDateTime(implode('.', $path)));
    }

    public function testDateTimeFromTransformer(): void
    {
        $path = [self::KeyItems, '0', self::KeyUpdatedAt];
        $dateTime = new DateTime('2022-02-01 23:22:21');
        $result = $this->data
            ->getDateTime(
                $path,
                transformers: [new TrimAndEmptyStringToNull(), new ClosureTransformer(fn () => $dateTime)]
            );

        $this->assertSame($dateTime, $result);
    }

    public function testDotNotationNotAnArray(): void
    {
        $path = [self::KeyItems, '0'];
        $this->expectExceptionMessage('Validation failed for <items.0> key. Reason: StringRule failed');
        $this->data->getDateTime($path);
    }

    protected function getRequiredValue(GetValue $data, array $rules): mixed
    {
        return $data->getRequiredDateTime(self::KeyUpdatedAt, $rules);
    }

    protected function getOptionalValue(GetValue $data, array $rules): mixed
    {
        return $data->getDateTime(self::KeyUpdatedAt, $rules);
    }

    protected function getDateTime(): DateTime
    {
        return new DateTime('2022-02-02 23:22:21');
    }
}

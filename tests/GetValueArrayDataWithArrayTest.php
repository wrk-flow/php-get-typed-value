<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests;

use PHPUnit\Framework\Attributes\DataProvider;
use Wrkflow\GetValue\Contracts\RuleContract;
use Wrkflow\GetValue\Exceptions\AbstractGetValueException;
use Wrkflow\GetValue\Exceptions\ArrayIsEmptyException;
use Wrkflow\GetValue\Exceptions\NotSupportedDataException;
use Wrkflow\GetValue\GetValue;

class GetValueArrayDataWithArrayTest extends AbstractArrayTestsTestCase
{
    /**
     * @return array<array-key, array<int, mixed>>
     */
    public static function requiredData(): array
    {
        return [
            self::KeyNull . ' throws exception' => [self::KeyNull, null, ArrayIsEmptyException::class],
            self::KeyEmpty . ' throws exception' => [self::KeyEmpty, null, ArrayIsEmptyException::class],
            self::KeyValid . ' returns value' => [self::KeyValid, ['test']],
            self::KeyInvalid . ' returns value' => [self::KeyInvalid, null, NotSupportedDataException::class],
            self::KeyMissingValue . ' throws exception' => [self::KeyMissingValue, null, ArrayIsEmptyException::class],
        ];
    }

    /**
     * @return array<array-key, array<int, mixed>>
     */
    public static function optionalData(): array
    {
        return [
            self::KeyNull . ' is converted to array' => [self::KeyNull, []],
            self::KeyEmpty . ' returns value' => [self::KeyEmpty, []],
            self::KeyInvalid . ' returns value' => [self::KeyInvalid, null, NotSupportedDataException::class],
            self::KeyValid . ' returns value' => [self::KeyValid, ['test']],
            self::KeyMissingValue . ' is converted to array' => [self::KeyMissingValue, []],
        ];
    }

    /**
     * @return array<array-key, array<int, mixed>>
     */
    public static function noStrategyData(): array
    {
        return self::optionalData();
    }

    /**
     * @return array<array-key, array<int, mixed>>
     */
    public static function nullableArrayData(): array
    {
        return [
            self::KeyNull . ' returns value' => [self::KeyNull, null],
            self::KeyEmpty . ' returns value' => [self::KeyEmpty, []],
            self::KeyInvalid . ' returns value' => [self::KeyInvalid, null, NotSupportedDataException::class],
            self::KeyValid . ' returns value' => [self::KeyValid, ['test']],
            self::KeyMissingValue . ' is converted to null' => [self::KeyMissingValue, null],
        ];
    }

    /**
     * @param string|array<int, string> $key
     * @param class-string<AbstractGetValueException>|null $expectedException
     */
    #[DataProvider('nullableArrayData')]
    public function testNullableArray(
        string|array $key,
        mixed $expectedValue = null,
        ?string $expectedException = null,
    ): void {
        $data = $this->getBaseData($expectedException, $key);

        $value = $data->getNullableArray(self::KeyTags);

        if ($expectedException === null) {
            $this->assertEquals($expectedValue, $value);
        }
    }

    public function testDotNotation(): void
    {
        $path = [self::KeyItems, '1', self::KeyTags];
        $this->assertEquals(['test'], $this->data->getArray($path));
        $this->assertEquals(['test'], $this->data->getArray(implode('.', $path)));
    }

    public function testDotNotationNotAnArray(): void
    {
        $path = [self::KeyPageString];
        $this->expectExceptionMessage('Given value is not array for key <page_string>');
        $this->data->getArray($path);
    }

    protected function getRequiredValue(GetValue $data, array $rules): mixed
    {
        return $data->getRequiredArray(self::KeyTags);
    }

    /**
     * @param array<RuleContract> $rules
     */
    protected function getOptionalValue(GetValue $data, array $rules): mixed
    {
        return $data->getArray(self::KeyTags);
    }
}

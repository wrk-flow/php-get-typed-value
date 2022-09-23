<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests;

use DateTime;
use Exception;
use SimpleXMLElement;
use Wrkflow\GetValue\Contracts\TransformerStrategyContract;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\Exceptions\NotSupportedDataException;
use Wrkflow\GetValue\Exceptions\NotXMLException;
use Wrkflow\GetValue\Exceptions\ValidationFailedException;
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\Strategies\DefaultTransformerStrategy;
use Wrkflow\GetValue\Strategies\NoTransformerStrategy;

class GetValueArrayDataStrategyTest extends AbstractArrayTestCase
{
    final public const KeyInt = 'int';

    final public const KeyFloat = 'float';

    final public const KeyString = 'string';

    final public const KeyDateTime = 'dateTime';

    final public const KeyArray = 'array';

    final public const KeyXml = 'xml';

    final public const ValueDateTime = '2022-09-23 00:01:01.00';

    /**
     * @dataProvider emptyStrategyValues
     */
    public function testEmptyStrategyValuesDoesNotConvertEmptyStringToNull(
        mixed $value,
        ?array $expectedResultValue = null
    ): void {
        $this->assertValues(
            strategy: new NoTransformerStrategy(),
            value: $value,
            expectedResultValue: $expectedResultValue
        );
    }

    public function emptyStrategyValues(): array
    {
        return [
            [null],
            [
                '', [
                    self::KeyString => '',
                ], ],
            ...$this->invalidStrategyValues(),
        ];
    }

    /**
     * @dataProvider defaultStrategyValues
     */
    public function testDefaultStrategyValuesConvertsEmptyStringToNull(
        mixed $value,
        ?array $expectedResultValue = null
    ): void {
        $this->assertValues(
            strategy: new DefaultTransformerStrategy(),
            value: $value,
            expectedResultValue: $expectedResultValue
        );
    }

    public function defaultStrategyValues(): array
    {
        return [[''], [null], ...$this->invalidStrategyValues()];
    }

    public function invalidStrategyValues(): array
    {
        $xml = new SimpleXMLElement('<root />');
        return [
            'expects to raise error for non int/float/string on int value' => [
                1, [
                    self::KeyInt => 1,
                    self::KeyFloat => 1,
                    self::KeyString => '1',
                ], ],
            'expects to raise error for non int/float/string on string value' => [
                '1', [
                    self::KeyInt => 1,
                    self::KeyFloat => 1,
                    self::KeyString => '1',
                ], ],
            'expects to raise error for non array on array value' => [[], [
                self::KeyArray => [],
            ]],
            'expects to raise error for non xml on xml value' => [
                $xml, [
                    self::KeyXml => $xml,
                ], ],
            'expects to raise error for non string/dateTime on dateTime value' => [
                self::ValueDateTime, [
                    self::KeyDateTime => new DateTime(self::ValueDateTime),
                    self::KeyString => self::ValueDateTime,
                ], ],
        ];
    }

    public function assertValues(
        TransformerStrategyContract $strategy,
        mixed $value,
        ?array $expectedResultValue = null
    ): void {
        $getters = [
            self::KeyInt => fn (string $key, GetValue $getValue) => $getValue->getInt($key),
            self::KeyFloat => fn (string $key, GetValue $getValue) => $getValue->getFloat($key),
            self::KeyString => fn (string $key, GetValue $getValue) => $getValue->getString($key),
            self::KeyArray => fn (string $key, GetValue $getValue) => $getValue->getNullableArray($key),
            self::KeyDateTime => fn (string $key, GetValue $getValue) => $getValue->getDateTime($key),
            self::KeyXml => fn (string $key, GetValue $getValue) => $getValue->getNullableXML($key),
        ];

        $getValue = new GetValue(new ArrayData(array_map(fn () => $value, $getters)), transformerStrategy: $strategy);
        foreach ($getters as $type => $closure) {
            if ($expectedResultValue === null) {
                $result = $closure($type, $getValue);
                $this->assertEquals(null, $result);
                continue;
            }

            if (array_key_exists($type, $expectedResultValue)) {
                $result = $closure($type, $getValue);
                $this->assertEquals($expectedResultValue[$type], $result);
                continue;
            }

            try {
                $closure($type, $getValue);
            } catch (ValidationFailedException) {
                continue;
            } catch (NotSupportedDataException $notSupportedDataException) {
                $this->assertEquals(
                    'Given value is not array for key <array>',
                    $notSupportedDataException->getMessage()
                );
                continue;
            } catch (NotXMLException $notxmlException) {
                $this->assertEquals('Given value is not a XML <xml>', $notxmlException->getMessage());
                continue;
            } catch (Exception $exception) {
                $this->assertStringContainsString('Failed to parse time string', $exception->getMessage());
                continue;
            }

            $this->fail('Validation should fail for ' . $type);
        }
    }
}

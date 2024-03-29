<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Transformers;

use Closure;
use SimpleXMLElement;
use Wrkflow\GetValue\Contracts\TransformerContract;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\DataHolders\XMLData;
use Wrkflow\GetValue\Exceptions\NotSupportedDataException;
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\Transformers\ArrayItemGetterTransformer;

final class ArrayItemGetterTransformerTest extends AbstractTransformerTestCase
{
    public const KeyValue = 'key';

    public const ValueToReturnNull = 'return_null';

    public function testExampleArray(): void
    {
        $data = new GetValue(new ArrayData([
            'names' => [[
                'name' => 'Marco',
                'surname' => 'Polo',
            ], [
                'name' => 'Martin',
                'surname' => 'Way',

            ]],
        ]));

        $transformer = new ArrayItemGetterTransformer(fn (GetValue $value, string $key): string => implode(' ', [
            $value->getRequiredString('name'),
            $value->getRequiredString('surname'),
        ]));

        $values = $data->getArray('names', transformers: [$transformer]);
        $this->assertEquals(['Marco Polo', 'Martin Way'], $values);

        $values = $data->getArray('names', transformers: [new ArrayItemGetterTransformer(new GetNameTransformer())]);
        $this->assertEquals(['Marco Polo', 'Martin Way'], $values);
    }

    public function testExampleXML(): void
    {
        $data = new GetValue(new XMLData(new SimpleXMLElement(
            <<<'CODE_SAMPLE'
<root>
    <names>
        <name>Marco</name>
        <surname number="3">Polo</surname>
    </names>
    <names>
        <name>Martin</name>
        <surname number="2">Way</surname>
    </names>
    
</root>
CODE_SAMPLE
        )));

        $expectedKeys = ['names.0', 'names.1'];

        $transformer = new ArrayItemGetterTransformer(function (GetValue $value, string $key) use (
            &$expectedKeys
        ): string {
            $expectedKey = array_shift($expectedKeys);

            $this->assertEquals($expectedKey, $key, 'Key does not match up');

            return implode(' ', [
                $value->getRequiredString('name'),
                $value->getRequiredString('surname'),
                $value->getXMLAttributesGetter(['surname'])->getRequiredInt('number'),
            ]);
        });

        $values = $data->getArray('names', transformers: [$transformer]);
        $this->assertEquals(['Marco Polo 3', 'Martin Way 2'], $values);
        $this->assertEmpty($expectedKeys, 'Expected key match should be empty - loop did not go through all keys');
    }

    public function dataToTest(): array
    {
        return $this->dataAfterValidationForTransformer();
    }

    /**
     * @dataProvider dataToTestBeforeValidation
     */
    public function testBeforeValidation(TransformerExpectationEntity $entity): void
    {
        $this->assertValue($this->getBeforeValidationTransformer($entity), $entity);
    }

    public function dataToTestBeforeValidation(): array
    {
        return $this->createData(false, false);
    }

    /**
     * @dataProvider dataToAfterValidationForce
     */
    public function testAfterValidationForce(TransformerExpectationEntity $entity): void
    {
        $this->assertValue($this->getForceAfterValidation($entity), $entity);
    }

    public function dataToAfterValidationForce(): array
    {
        return $this->dataAfterValidationForTransformer();
    }

    public function testSupportsEmptyArray(): void
    {
        $expectedKeys = ['test.0', 'test.1'];

        $transformer = new ArrayItemGetterTransformer(onItem: function (GetValue $value, string $key) use (
            &$expectedKeys
        ): array {
            $expectedKey = array_shift($expectedKeys);

            $this->assertEquals($expectedKey, $key, 'Key does not match up');

            return [
                'original' => $value->data->get(),
            ];
        });

        $testValue = [
            'test' => 'value',
        ];
        $value = [[], $testValue];
        $this->assertValue($transformer, new TransformerExpectationEntity(
            value: $value,
            expectedValue: [[
                'original' => [],
            ], [
                'original' => $testValue,
            ]],
            expectedValueBeforeValidation: $value,
        ));
        $this->assertEmpty($expectedKeys, 'Expected key match should be empty - loop did not go through all keys');
    }

    /**
     * @dataProvider dataToTestBeforeValidationLeaveNull
     */
    public function testBeforeValidationLeaveNull(TransformerExpectationEntity $entity): void
    {
        $this->assertValue(
            new ArrayItemGetterTransformer(
                onItem: $this->getClosure($entity),
                beforeValidation: true,
                ignoreNullResult: false
            ),
            $entity
        );
    }

    public function dataToTestBeforeValidationLeaveNull(): array
    {
        return $this->createData(false, true);
    }

    /**
     * @dataProvider dataToAfterValidationForceLeaveNull
     */
    public function testAfterValidationForceLeaveNull(TransformerExpectationEntity $entity): void
    {
        $this->assertValue(
            new ArrayItemGetterTransformer(
                onItem: $this->getClosure($entity),
                beforeValidation: false,
                ignoreNullResult: false
            ),
            $entity
        );
    }

    public function dataToAfterValidationForceLeaveNull(): array
    {
        return $this->createData(true, true);
    }

    /**
     * @dataProvider dataLeaveNull
     */
    public function testTransformLeaveNull(TransformerExpectationEntity $entity): void
    {
        $this->assertValue(
            new ArrayItemGetterTransformer(onItem: $this->getClosure($entity), ignoreNullResult: false),
            $entity
        );
    }

    public function dataLeaveNull(): array
    {
        return $this->createData(true, true);
    }

    protected function dataAfterValidationForTransformer(): array
    {
        return $this->createData(true, false);
    }

    protected function getClosure(TransformerExpectationEntity $entity): Closure
    {
        return function (GetValue $value, string $key) use (&$entity): ?array {
            $expectedKey = array_shift($entity->expectedKey);
            $this->assertEquals($expectedKey, $key, 'Key does not match up');

            $value = $value->getRequiredString(self::KeyValue, transformers: []);

            if ($value === self::ValueToReturnNull) {
                return null;
            }

            return [
                // we are working with empty strings - do not convert to null
                self::KeyValue => md5($value),
            ];
        };
    }

    protected function getTransformer(TransformerExpectationEntity $entity): TransformerContract
    {
        return new ArrayItemGetterTransformer(onItem: $this->getClosure($entity));
    }

    private function getBeforeValidationTransformer(TransformerExpectationEntity $entity): TransformerContract
    {
        return new ArrayItemGetterTransformer(onItem: $this->getClosure($entity), beforeValidation: true);
    }

    private function getForceAfterValidation(TransformerExpectationEntity $entity): TransformerContract
    {
        return new ArrayItemGetterTransformer(onItem: $this->getClosure($entity), beforeValidation: false);
    }

    private function createData(bool $beforeValueIsSameAsValue, bool $leaveNull): array
    {
        return [
            [
                new TransformerExpectationEntity(
                    value: [[
                        self::KeyValue => '',
                    ]],
                    expectedValue: [[
                        self::KeyValue => 'd41d8cd98f00b204e9800998ecf8427e',
                    ]],
                    expectedValueBeforeValidation: $beforeValueIsSameAsValue ? [[
                        self::KeyValue => '',
                    ]] : null,
                    expectedKey: 'test.0',
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: [[
                        self::KeyValue => ' ',
                    ]],
                    expectedValue: [[
                        self::KeyValue => '7215ee9c7d9dc229d2921a40e899ec5f',
                    ]],
                    expectedValueBeforeValidation: $beforeValueIsSameAsValue ? [[
                        self::KeyValue => ' ',
                    ]] : null,
                    expectedKey: 'test.0',
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: [[
                        self::KeyValue => ' asd ',
                    ]],
                    expectedValue: [[
                        self::KeyValue => '81c24eeebdef51c832407fa3e4509ab8',
                    ]],
                    expectedValueBeforeValidation: $beforeValueIsSameAsValue ? [[
                        self::KeyValue => ' asd ',
                    ]] : null,
                    expectedKey: 'test.0',
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: [[
                        self::KeyValue => 'asd ',
                    ]],
                    expectedValue: [[
                        self::KeyValue => '4fe2077508f28d88bfa1473149415224',
                    ]],
                    expectedValueBeforeValidation: $beforeValueIsSameAsValue ? [[
                        self::KeyValue => 'asd ',
                    ]] : null,
                    expectedKey: 'test.0',
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: [[
                        self::KeyValue => 'asd mix',
                    ]],
                    expectedValue: [[
                        self::KeyValue => 'bf40744fb5eeca1029aed8d8c5d30f82',
                    ]],
                    expectedValueBeforeValidation: $beforeValueIsSameAsValue ? [[
                        self::KeyValue => 'asd mix',
                    ]] : null,
                    expectedKey: 'test.0',
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: [
                        'test' => [
                            self::KeyValue => 'asd mix',
                        ],
                    ],
                    expectedValue: [
                        'test' => [
                            self::KeyValue => 'bf40744fb5eeca1029aed8d8c5d30f82',
                        ],
                    ],
                    expectedValueBeforeValidation: $beforeValueIsSameAsValue ? [
                        'test' => [
                            self::KeyValue => 'asd mix',
                        ],
                    ] : null,
                    expectedKey: 'test.test',
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: [[
                        self::KeyValue => self::ValueToReturnNull,
                    ]],
                    expectedValue: $leaveNull ? [null] : [],
                    expectedValueBeforeValidation: $beforeValueIsSameAsValue ? [[
                        self::KeyValue => self::ValueToReturnNull,
                    ]] : null,
                    expectedKey: 'test.0',
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: [
                        'test' => [
                            self::KeyValue => self::ValueToReturnNull,
                        ],
                    ],
                    expectedValue: $leaveNull ? [
                        'test' => null,
                    ] : [],
                    expectedValueBeforeValidation: $beforeValueIsSameAsValue ? [
                        'test' => [
                            self::KeyValue => self::ValueToReturnNull,
                        ],
                    ] : null,
                    expectedKey: 'test.test',
                ),
            ],
            [new TransformerExpectationEntity(value: null, expectedValue: null)],
            [
                new TransformerExpectationEntity(
                    value: ['test'],
                    expectedValue: null,
                    expectException: NotSupportedDataException::class,
                ),
            ],
        ];
    }
}

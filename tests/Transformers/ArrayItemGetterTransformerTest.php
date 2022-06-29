<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Transformers;

use Closure;
use Wrkflow\GetValue\Contracts\TransformerArrayContract;
use Wrkflow\GetValue\Exceptions\NotAnArrayException;
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\Transformers\ArrayItemGetterTransformer;

class ArrayItemGetterTransformerTest extends AbstractTransformerTestCase
{
    final public const KeyValue = 'key';

    public function dataToTest(): array
    {
        return $this->dataAfterValidationForTransformer();
    }

    public function dataToTestBeforeValidation(): array
    {
        return $this->createData(false);
    }

    /**
     * @dataProvider dataToTestBeforeValidation
     */
    public function testBeforeValidation(TransformerExpectationEntity $entity): void
    {
        $this->assertValue($this->getBeforeValidationTransformer(), $entity);
    }

    public function dataToAfterValidationForce(): array
    {
        return $this->dataAfterValidationForTransformer();
    }

    /**
     * @dataProvider dataToAfterValidationForce
     */
    public function testAfterValidationForce(TransformerExpectationEntity $entity): void
    {
        $this->assertValue($this->getForceAfterValidation(), $entity);
    }

    public function testSupportsEmptyArray(): void
    {
        $transformer = new ArrayItemGetterTransformer(onItem: function (GetValue $value, string $key): array {
            $this->assertEquals('test', $key, 'Key does not match up');

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
            expectedValueBeforeValidation: $value
        ));
    }

    protected function dataAfterValidationForTransformer(): array
    {
        return $this->createData(true);
    }

    protected function getClosure(): Closure
    {
        return function (GetValue $value, string $key): array {
            $this->assertEquals('test', $key, 'Key does not match up');

            return [
                // we are working with empty strings - do not convert to null
                self::KeyValue => md5($value->getRequiredString(self::KeyValue, transformers: [])),
            ];
        };
    }

    protected function getTransformer(): TransformerArrayContract
    {
        return new ArrayItemGetterTransformer(onItem: $this->getClosure());
    }

    protected function getBeforeValidationTransformer(): TransformerArrayContract
    {
        return new ArrayItemGetterTransformer(onItem: $this->getClosure(), beforeValidation: true);
    }

    protected function getForceAfterValidation(): TransformerArrayContract
    {
        return new ArrayItemGetterTransformer(onItem: $this->getClosure(), beforeValidation: false);
    }

    protected function createData(bool $beforeValueIsSameAsValue): array
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
                    ]] : null
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
                    ]] : null
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
                    ]] : null
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
                    ]] : null
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
                    ]] : null
                ),
            ],
            [new TransformerExpectationEntity(value: null, expectedValue: null)],
            [
                new TransformerExpectationEntity(value: [
                    'test',
                ], expectedValue: null, expectException: NotAnArrayException::class),
            ],
        ];
    }
}

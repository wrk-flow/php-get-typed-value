<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Transformers;

use Closure;
use Wrkflow\GetValue\Contracts\TransformerArrayContract;
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\Transformers\ArrayGetterTransformer;

class ArrayGetterTransformerTest extends AbstractTransformerTestCase
{
    final public const Key = 'key';

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

    protected function dataAfterValidationForTransformer(): array
    {
        return $this->createData(true);
    }

    protected function getClosure(): Closure
    {
        return function (GetValue $value, string $key): array {
            $this->assertEquals('test', $key, 'Key does not match up');

            return [
                // Remove transformers (we are using empty string)
                self::Key => md5($value->getRequiredString(self::Key, transformers: [])),
            ];
        };
    }

    protected function getTransformer(): TransformerArrayContract
    {
        return new ArrayGetterTransformer($this->getClosure());
    }

    protected function getBeforeValidationTransformer(): TransformerArrayContract
    {
        return new ArrayGetterTransformer(closure: $this->getClosure(), beforeValidation: true);
    }

    protected function getForceAfterValidation(): TransformerArrayContract
    {
        return new ArrayGetterTransformer(closure: $this->getClosure(), beforeValidation: false);
    }

    protected function createData(bool $beforeValueIsSameAsValue): array
    {
        return [
            [
                new TransformerExpectationEntity(
                    value: [
                        self::Key => '',
                    ],
                    expectedValue: [
                        self::Key => 'd41d8cd98f00b204e9800998ecf8427e',
                    ],
                    expectedValueBeforeValidation: $beforeValueIsSameAsValue ? [
                        self::Key => '',
                    ] : null
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: [
                        self::Key => ' ',
                    ],
                    expectedValue: [
                        self::Key => '7215ee9c7d9dc229d2921a40e899ec5f',
                    ],
                    expectedValueBeforeValidation: $beforeValueIsSameAsValue ? [
                        self::Key => ' ',
                    ] : null
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: [
                        self::Key => ' asd ',
                    ],
                    expectedValue: [
                        self::Key => '81c24eeebdef51c832407fa3e4509ab8',
                    ],
                    expectedValueBeforeValidation: $beforeValueIsSameAsValue ? [
                        self::Key => ' asd ',
                    ] : null
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: [
                        self::Key => 'asd ',
                    ],
                    expectedValue: [
                        self::Key => '4fe2077508f28d88bfa1473149415224',
                    ],
                    expectedValueBeforeValidation: $beforeValueIsSameAsValue ? [
                        self::Key => 'asd ',
                    ] : null
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: [
                        self::Key => 'asd mix',
                    ],
                    expectedValue: [
                        self::Key => 'bf40744fb5eeca1029aed8d8c5d30f82',
                    ],
                    expectedValueBeforeValidation: $beforeValueIsSameAsValue ? [
                        self::Key => 'asd mix',
                    ] : null
                ),
            ],
            // Closure not called
            [new TransformerExpectationEntity(value: null, expectedValue: null)],
        ];
    }
}

<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Transformers;

use Wrkflow\GetValue\Transformers\ClosureTransformer;

class ClosureTransformerTest extends AbstractTransformerTestCase
{
    public function dataToTest(): array
    {
        $transformer = new ClosureTransformer(function (mixed $value, string $key): ?string {
            if ($value === null) {
                return null;
            }

            $this->assertEquals('test', $key, 'Key does not match up');
            return md5($value);
        });

        return $this->dataAfterValidationForTransformer($transformer);
    }

    public function dataToTestBeforeValidation(): array
    {
        $transformer = new ClosureTransformer(
            closure: function (mixed $value, string $key): ?string {
                if ($value === null) {
                    return null;
                }

                $this->assertEquals('test', $key, 'Key does not match up');
                return md5($value);
            },
            beforeValidation: true
        );

        return [
            [
                new TransformerExpectationEntity(
                    value: '',
                    transformer: $transformer,
                    expectedValue: 'd41d8cd98f00b204e9800998ecf8427e'
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: ' ',
                    transformer: $transformer,
                    expectedValue: '7215ee9c7d9dc229d2921a40e899ec5f'
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: ' asd ',
                    transformer: $transformer,
                    expectedValue: '81c24eeebdef51c832407fa3e4509ab8'
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: 'asd ',
                    transformer: $transformer,
                    expectedValue: '4fe2077508f28d88bfa1473149415224'
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: 'asd mix',
                    transformer: $transformer,
                    expectedValue: 'bf40744fb5eeca1029aed8d8c5d30f82'
                ),
            ],
            [new TransformerExpectationEntity(value: null, transformer: $transformer, expectedValue: null)],
        ];
    }

    /**
     * @dataProvider dataToTestBeforeValidation
     */
    public function testBeforeValidation(TransformerExpectationEntity $entity): void
    {
        $this->assertValue($entity);
    }

    public function dataToTestBeforeValidationForce(): array
    {
        $transformer = new ClosureTransformer(
            closure: function (mixed $value, string $key): ?string {
                if ($value === null) {
                    return null;
                }

                $this->assertEquals('test', $key, 'Key does not match up');
                return md5($value);
            },
            beforeValidation: false
        );

        return $this->dataAfterValidationForTransformer($transformer);
    }

    /**
     * @dataProvider dataToTestBeforeValidationForce
     */
    public function testAfterValidationForce(TransformerExpectationEntity $entity): void
    {
        $this->assertValue($entity);
    }

    protected function dataAfterValidationForTransformer(ClosureTransformer $transformer): array
    {
        return [
            [
                new TransformerExpectationEntity(
                    value: '',
                    transformer: $transformer,
                    expectedValue: 'd41d8cd98f00b204e9800998ecf8427e',
                    expectedValueBeforeValidation: ''
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: ' ',
                    transformer: $transformer,
                    expectedValue: '7215ee9c7d9dc229d2921a40e899ec5f',
                    expectedValueBeforeValidation: ' '
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: ' asd ',
                    transformer: $transformer,
                    expectedValue: '81c24eeebdef51c832407fa3e4509ab8',
                    expectedValueBeforeValidation: ' asd '
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: 'asd ',
                    transformer: $transformer,
                    expectedValue: '4fe2077508f28d88bfa1473149415224',
                    expectedValueBeforeValidation: 'asd '
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: 'asd mix',
                    transformer: $transformer,
                    expectedValue: 'bf40744fb5eeca1029aed8d8c5d30f82',
                    expectedValueBeforeValidation: 'asd mix'
                ),
            ],
            [new TransformerExpectationEntity(value: null, transformer: $transformer, expectedValue: null)],
        ];
    }
}

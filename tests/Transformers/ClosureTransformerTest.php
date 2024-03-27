<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Transformers;

use Closure;
use Wrkflow\GetValue\Contracts\TransformerContract;
use Wrkflow\GetValue\Transformers\ClosureTransformer;

class ClosureTransformerTest extends AbstractTransformerTestCase
{
    public function dataToTest(): array
    {
        return $this->dataAfterValidationForTransformer();
    }

    public function dataToBeforeValidationForce(): array
    {
        return [
            [new TransformerExpectationEntity(value: '', expectedValue: 'd41d8cd98f00b204e9800998ecf8427e')],
            [new TransformerExpectationEntity(value: ' ', expectedValue: '7215ee9c7d9dc229d2921a40e899ec5f')],
            [new TransformerExpectationEntity(value: ' asd ', expectedValue: '81c24eeebdef51c832407fa3e4509ab8')],
            [new TransformerExpectationEntity(value: 'asd ', expectedValue: '4fe2077508f28d88bfa1473149415224')],
            [
                new TransformerExpectationEntity(
                    value: 'asd mix',
                    expectedValue: 'bf40744fb5eeca1029aed8d8c5d30f82'
                ),
            ],
            [new TransformerExpectationEntity(value: null, expectedValue: null)],
        ];
    }

    /**
     * @dataProvider dataToBeforeValidationForce
     */
    public function testBeforeValidation(TransformerExpectationEntity $entity): void
    {
        $transformer = new ClosureTransformer(closure: $this->getClosure(), beforeValidation: true);

        $this->assertValue($transformer, $entity);
    }

    public function dataToTestAfterValidationForce(): array
    {
        return $this->dataAfterValidationForTransformer();
    }

    /**
     * @dataProvider dataToTestAfterValidationForce
     */
    public function testAfterValidationForce(TransformerExpectationEntity $entity): void
    {
        $transformer = new ClosureTransformer(closure: $this->getClosure(), beforeValidation: false);

        $this->assertValue($transformer, $entity);
    }

    protected function getTransformer(TransformerExpectationEntity $entity): TransformerContract
    {
        return new ClosureTransformer(closure: $this->getClosure());
    }

    protected function dataAfterValidationForTransformer(): array
    {
        return [
            [
                new TransformerExpectationEntity(
                    value: '',
                    expectedValue: 'd41d8cd98f00b204e9800998ecf8427e',
                    expectedValueBeforeValidation: ''
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: ' ',
                    expectedValue: '7215ee9c7d9dc229d2921a40e899ec5f',
                    expectedValueBeforeValidation: ' '
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: ' asd ',
                    expectedValue: '81c24eeebdef51c832407fa3e4509ab8',
                    expectedValueBeforeValidation: ' asd '
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: 'asd ',
                    expectedValue: '4fe2077508f28d88bfa1473149415224',
                    expectedValueBeforeValidation: 'asd '
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: 'asd mix',
                    expectedValue: 'bf40744fb5eeca1029aed8d8c5d30f82',
                    expectedValueBeforeValidation: 'asd mix'
                ),
            ],
            [new TransformerExpectationEntity(value: null, expectedValue: null)],
        ];
    }

    protected function getClosure(): Closure
    {
        return function (mixed $value, string $key): ?string {
            if ($value === null) {
                return null;
            }

            $this->assertEquals('test', $key, 'Key does not match up');
            return md5($value);
        };
    }
}

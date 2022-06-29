<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Transformers;

use Closure;
use Wrkflow\GetValue\Contracts\TransformerArrayContract;
use Wrkflow\GetValue\Transformers\ArrayTransformer;

class ArrayTransformerTest extends AbstractTransformerTestCase
{
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
        return function (array $value, string $key): array {
            $this->assertEquals('test', $key, 'Key does not match up');

            return array_map(fn (string $item) => md5($item), $value);
        };
    }

    protected function getTransformer(): TransformerArrayContract
    {
        return new ArrayTransformer($this->getClosure());
    }

    protected function getBeforeValidationTransformer(): TransformerArrayContract
    {
        return new ArrayTransformer(closure: $this->getClosure(), beforeValidation: true);
    }

    protected function getForceAfterValidation(): TransformerArrayContract
    {
        return new ArrayTransformer(closure: $this->getClosure(), beforeValidation: false);
    }

    protected function createData(bool $beforeValueIsSameAsValue): array
    {
        return [
            [
                new TransformerExpectationEntity(
                    value: [''],
                    expectedValue: ['d41d8cd98f00b204e9800998ecf8427e'],
                    expectedValueBeforeValidation: $beforeValueIsSameAsValue ? [''] : null
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: [' '],
                    expectedValue: ['7215ee9c7d9dc229d2921a40e899ec5f'],
                    expectedValueBeforeValidation: $beforeValueIsSameAsValue ? [' '] : null
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: [' asd '],
                    expectedValue: ['81c24eeebdef51c832407fa3e4509ab8'],
                    expectedValueBeforeValidation: $beforeValueIsSameAsValue ? [' asd '] : null
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: ['asd '],
                    expectedValue: ['4fe2077508f28d88bfa1473149415224'],
                    expectedValueBeforeValidation: $beforeValueIsSameAsValue ? ['asd '] : null
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: ['asd mix'],
                    expectedValue: ['bf40744fb5eeca1029aed8d8c5d30f82'],
                    expectedValueBeforeValidation: $beforeValueIsSameAsValue ? ['asd mix'] : null
                ),
            ],
            // Closure not called
            [new TransformerExpectationEntity(value: null, expectedValue: null)],
        ];
    }
}

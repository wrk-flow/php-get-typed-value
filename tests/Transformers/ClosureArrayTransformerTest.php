<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Transformers;

use Closure;
use Wrkflow\GetValue\Contracts\TransformerArrayContract;
use Wrkflow\GetValue\Transformers\ClosureArrayTransformer;

class ClosureArrayTransformerTest extends AbstractTransformerTestCase
{
    public function dataToTest(): array
    {
        $transformer = $this->getDefaultTransformer();

        return $this->dataAfterValidationForTransformer($transformer);
    }

    public function dataToTestBeforeValidation(): array
    {
        $transformer = $this->getBeforeValidationTransformer();

        return [
            [
                new TransformerExpectationEntity(
                    value: [''],
                    transformer: $transformer,
                    expectedValue: ['d41d8cd98f00b204e9800998ecf8427e']
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: [' '],
                    transformer: $transformer,
                    expectedValue: ['7215ee9c7d9dc229d2921a40e899ec5f']
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: [' asd '],
                    transformer: $transformer,
                    expectedValue: ['81c24eeebdef51c832407fa3e4509ab8']
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: ['asd '],
                    transformer: $transformer,
                    expectedValue: ['4fe2077508f28d88bfa1473149415224']
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: ['asd mix'],
                    transformer: $transformer,
                    expectedValue: ['bf40744fb5eeca1029aed8d8c5d30f82']
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

    public function dataToAfterValidationForce(): array
    {
        $transformer = $this->getForceAfterValidation();

        return $this->dataAfterValidationForTransformer($transformer);
    }

    /**
     * @dataProvider dataToAfterValidationForce
     */
    public function testAfterValidationForce(TransformerExpectationEntity $entity): void
    {
        $this->assertValue($entity);
    }

    protected function dataAfterValidationForTransformer(TransformerArrayContract $transformer): array
    {
        return [
            [
                new TransformerExpectationEntity(
                    value: [''],
                    transformer: $transformer,
                    expectedValue: ['d41d8cd98f00b204e9800998ecf8427e'],
                    expectedValueBeforeValidation: ['']
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: [' '],
                    transformer: $transformer,
                    expectedValue: ['7215ee9c7d9dc229d2921a40e899ec5f'],
                    expectedValueBeforeValidation: [' ']
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: [' asd '],
                    transformer: $transformer,
                    expectedValue: ['81c24eeebdef51c832407fa3e4509ab8'],
                    expectedValueBeforeValidation: [' asd ']
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: ['asd '],
                    transformer: $transformer,
                    expectedValue: ['4fe2077508f28d88bfa1473149415224'],
                    expectedValueBeforeValidation: ['asd ']
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: ['asd mix'],
                    transformer: $transformer,
                    expectedValue: ['bf40744fb5eeca1029aed8d8c5d30f82'],
                    expectedValueBeforeValidation: ['asd mix']
                ),
            ],
            // Closure not called
            [new TransformerExpectationEntity(value: null, transformer: $transformer, expectedValue: null)],
        ];
    }

    protected function getClosure(): Closure
    {
        return function (array $value, string $key): array {
            $this->assertEquals('test', $key, 'Key does not match up');

            return array_map(fn (string $item) => md5($item), $value);
        };
    }

    protected function getDefaultTransformer(): TransformerArrayContract
    {
        return new ClosureArrayTransformer($this->getClosure());
    }

    protected function getBeforeValidationTransformer(): TransformerArrayContract
    {
        return new ClosureArrayTransformer(closure: $this->getClosure(), beforeValidation: true);
    }

    protected function getForceAfterValidation(): TransformerArrayContract
    {
        return new ClosureArrayTransformer(closure: $this->getClosure(), beforeValidation: false);
    }
}

<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Transformers;

use Closure;
use Wrkflow\GetValue\Contracts\TransformerContract;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\Exceptions\ValidationFailedException;
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\Transformers\ArrayItemTransformer;

class ArrayItemTransformerTest extends AbstractTransformerTestCase
{
    public function testExample(): void
    {
        $data = new GetValue(new ArrayData([
            'names' => ['Marco Polo', 'Way Point', ''],
        ]));
        $transformer = new ArrayItemTransformer(function (mixed $value, string $key): ?array {
            if (is_string($value) === false) {
                throw new ValidationFailedException($key, 'expecting string');
            }

            if ($value === '') {
                return null;
            }

            return explode(' ', $value);
        });

        $values = $data->getArray('names', transformers: [$transformer]);
        $this->assertSame($values, [['Marco', 'Polo'], ['Way', 'Point']]);
    }

    public function testExampleIgnoreNullResult(): void
    {
        $data = new GetValue(new ArrayData([
            'names' => ['Marco Polo', 'Way Point', ''],
        ]));
        $transformer = new ArrayItemTransformer(function (mixed $value, string $key): ?array {
            if (is_string($value) === false) {
                throw new ValidationFailedException($key, 'expecting string');
            }

            if ($value === '') {
                return null;
            }

            return explode(' ', $value);
        }, ignoreNullResult: false);

        $values = $data->getArray('names', transformers: [$transformer]);
        $this->assertSame($values, [['Marco', 'Polo'], ['Way', 'Point'], null]);
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
        $this->assertValue(new ArrayItemTransformer(onItem: $this->getClosure(), beforeValidation: true), $entity);
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
        $this->assertValue(new ArrayItemTransformer(onItem: $this->getClosure(), beforeValidation: false), $entity);
    }

    public function dataToAfterValidationForce(): array
    {
        return $this->dataAfterValidationForTransformer();
    }

    /**
     * @dataProvider dataToTestBeforeValidationLeaveNull
     */
    public function testBeforeValidationLeaveNull(TransformerExpectationEntity $entity): void
    {
        $this->assertValue(
            new ArrayItemTransformer(onItem: $this->getClosure(), beforeValidation: true, ignoreNullResult: false),
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
            new ArrayItemTransformer(onItem: $this->getClosure(), beforeValidation: false, ignoreNullResult: false),
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
        $this->assertValue(new ArrayItemTransformer(onItem: $this->getClosure(), ignoreNullResult: false), $entity);
    }

    public function dataLeaveNull(): array
    {
        return $this->createData(true, true);
    }

    protected function dataAfterValidationForTransformer(): array
    {
        return $this->createData(true, false);
    }

    protected function getClosure(): Closure
    {
        return function (mixed $value, string $key): ?string {
            $this->assertEquals('test', $key, 'Key does not match up');

            if ($value === null) {
                return null;
            }

            if (is_string($value) === false) {
                throw new ValidationFailedException($key, 'array value not a string');
            }

            return md5($value);
        };
    }

    protected function getTransformer(): TransformerContract
    {
        return new ArrayItemTransformer(onItem: $this->getClosure());
    }

    protected function createData(bool $beforeValueIsSameAsValue, bool $leaveNull): array
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
                    value: ['', null],
                    expectedValue: $leaveNull ? ['d41d8cd98f00b204e9800998ecf8427e', null] : [
                        'd41d8cd98f00b204e9800998ecf8427e',
                    ],
                    expectedValueBeforeValidation: $beforeValueIsSameAsValue ? ['', null] : null
                ),
            ],
            [
                new TransformerExpectationEntity(
                    // Ensure that associative array is not corrupted
                    value: [null, ' '],
                    expectedValue: $leaveNull ? [null, '7215ee9c7d9dc229d2921a40e899ec5f'] : [
                        '7215ee9c7d9dc229d2921a40e899ec5f',
                    ],
                    expectedValueBeforeValidation: $beforeValueIsSameAsValue ? [null, ' '] : null
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: [
                        'test' => ' asd ',
                    ],
                    expectedValue: [
                        'test' => '81c24eeebdef51c832407fa3e4509ab8',
                    ],
                    expectedValueBeforeValidation: $beforeValueIsSameAsValue ? [
                        'test' => ' asd ',
                    ] : null
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: [
                        'test' => 'asd ',
                        'rock' => null,
                    ],
                    expectedValue: $leaveNull ? [
                        'test' => '4fe2077508f28d88bfa1473149415224',
                        'rock' => null,
                    ] : [
                        'test' => '4fe2077508f28d88bfa1473149415224',
                    ],
                    expectedValueBeforeValidation: $beforeValueIsSameAsValue ? [
                        'test' => 'asd ',
                        'rock' => null,
                    ] : null
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

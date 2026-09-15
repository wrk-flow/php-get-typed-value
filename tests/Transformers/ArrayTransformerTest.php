<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Transformers;

use Closure;
use LogicException;
use PHPUnit\Framework\Attributes\DataProvider;
use Wrkflow\GetValue\Contracts\TransformerContract;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\Transformers\ArrayTransformer;

class ArrayTransformerTest extends AbstractTransformerTestCase
{
    public function testExample(): void
    {
        $data = new GetValue(new ArrayData([
            'key' => ['Marco', 'Polo'],
        ]));

        $closure = static function (array $value, string $key): string {
            $strings = [];
            foreach ($value as $item) {
                if (is_string($item) === false) {
                    throw new LogicException('The array item must be a string.');
                }
                $strings[] = $item;
            }

            return implode(' ', $strings);
        };
        $transformer = new ArrayTransformer(
            closure: $closure,
            beforeValidation: true,
        );

        $name = $data->getString('key', transformers: [$transformer]);
        $this->assertEquals('Marco Polo', $name);
    }

    #[DataProvider('dataToTestBeforeValidation')]
    public function testBeforeValidation(TransformerExpectationEntity $entity): void
    {
        $this->assertValue($this->getBeforeValidationTransformer(), $entity);
    }

    #[DataProvider('dataToAfterValidationForce')]
    public function testAfterValidationForce(TransformerExpectationEntity $entity): void
    {
        $this->assertValue($this->getForceAfterValidation(), $entity);
    }

    /**
     * @return array<array-key, array<int, TransformerExpectationEntity>>
     */
    public static function dataToAfterValidationForce(): array
    {
        return self::dataAfterValidationForTransformer();
    }

    /**
     * @return array<array-key, array<int, TransformerExpectationEntity>>
     */
    public static function dataToTest(): array
    {
        return self::dataAfterValidationForTransformer();
    }

    /**
     * @return array<array-key, array<int, TransformerExpectationEntity>>
     */
    public static function dataToTestBeforeValidation(): array
    {
        return self::createData(false);
    }

    /**
     * @return array<array-key, array<int, TransformerExpectationEntity>>
     */
    protected static function dataAfterValidationForTransformer(): array
    {
        return self::createData(true);
    }

    protected function getClosure(): Closure
    {
        return function (array $value, string $key): array {
            $this->assertEquals('test', $key, 'Key does not match up');

            return array_map(
                static fn (mixed $item): string => is_string($item)
                    ? md5($item)
                    : throw new LogicException('The array item must be a string.'),
                $value,
            );
        };
    }

    protected function getTransformer(TransformerExpectationEntity $entity): TransformerContract
    {
        return new ArrayTransformer($this->getClosure());
    }

    protected function getBeforeValidationTransformer(): TransformerContract
    {
        return new ArrayTransformer(closure: $this->getClosure(), beforeValidation: true);
    }

    protected function getForceAfterValidation(): TransformerContract
    {
        return new ArrayTransformer(closure: $this->getClosure(), beforeValidation: false);
    }

    /**
     * @return array<array-key, array<int, TransformerExpectationEntity>>
     */
    protected static function createData(bool $beforeValueIsSameAsValue): array
    {
        return [
            [
                new TransformerExpectationEntity(
                    value: [''],
                    expectedValue: ['d41d8cd98f00b204e9800998ecf8427e'],
                    expectedValueBeforeValidation: $beforeValueIsSameAsValue ? [''] : null,
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: [' '],
                    expectedValue: ['7215ee9c7d9dc229d2921a40e899ec5f'],
                    expectedValueBeforeValidation: $beforeValueIsSameAsValue ? [' '] : null,
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: [' asd '],
                    expectedValue: ['81c24eeebdef51c832407fa3e4509ab8'],
                    expectedValueBeforeValidation: $beforeValueIsSameAsValue ? [' asd '] : null,
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: ['asd '],
                    expectedValue: ['4fe2077508f28d88bfa1473149415224'],
                    expectedValueBeforeValidation: $beforeValueIsSameAsValue ? ['asd '] : null,
                ),
            ],
            [
                new TransformerExpectationEntity(
                    value: ['asd mix'],
                    expectedValue: ['bf40744fb5eeca1029aed8d8c5d30f82'],
                    expectedValueBeforeValidation: $beforeValueIsSameAsValue ? ['asd mix'] : null,
                ),
            ],
            // Closure not called
            [new TransformerExpectationEntity(value: null, expectedValue: null)],
        ];
    }
}

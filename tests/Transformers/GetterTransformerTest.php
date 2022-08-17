<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Transformers;

use Closure;
use Wrkflow\GetValue\Contracts\TransformerContract;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\Transformers\GetterTransformer;

class GetterTransformerTest extends AbstractTransformerTestCase
{
    final public const Key = 'key';

    public function testExample(): void
    {
        $data = new GetValue(new ArrayData([
            'person' => [
                'name' => 'Marco',
                'surname' => 'Polo',
            ],
        ]));

        $transformer = new GetterTransformer(fn (GetValue $value, string $key): string => implode(' ', [
            $value->getRequiredString('name'),
            $value->getRequiredString('surname'),
        ]), true);

        $value = $data->getString('person', transformers: [$transformer]);
        $this->assertEquals('Marco Polo', $value);

        $value = $data->getString('person', transformers: [new GetterTransformer(new GetNameTransformer(), true)]);
        $this->assertEquals('Marco Polo', $value);
    }

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
                self::Key => md5((string) $value->getRequiredString(self::Key, transformers: [])),
            ];
        };
    }

    protected function getTransformer(): TransformerContract
    {
        return new GetterTransformer($this->getClosure());
    }

    protected function getBeforeValidationTransformer(): TransformerContract
    {
        return new GetterTransformer(closure: $this->getClosure(), beforeValidation: true);
    }

    protected function getForceAfterValidation(): TransformerContract
    {
        return new GetterTransformer(closure: $this->getClosure(), beforeValidation: false);
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

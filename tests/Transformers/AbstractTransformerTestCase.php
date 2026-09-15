<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Transformers;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Wrkflow\GetValue\Actions\GetValidatedValueAction;
use Wrkflow\GetValue\Actions\ValidateAction;
use Wrkflow\GetValue\Builders\ExceptionBuilder;
use Wrkflow\GetValue\Contracts\TransformerContract;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\Enums\ValueType;
use Wrkflow\GetValue\GetValue;

abstract class AbstractTransformerTestCase extends TestCase
{
    private GetValidatedValueAction $action;
    private RuleWasCalledRule $wasCalledRule;

    protected function setUp(): void
    {
        parent::setUp();

        $this->wasCalledRule = new RuleWasCalledRule();
        $this->action = new GetValidatedValueAction(validateAction: new ValidateAction(new ExceptionBuilder()));
    }

    /**
     * @return array<array-key, array<int, TransformerExpectationEntity>>
     */
    abstract public static function dataToTest(): array;

    /**
     * @return array<array-key, array<int, TransformerExpectationEntity>>
     */
    public static function data(): array
    {
        $data = [];

        foreach (static::dataToTest() as $index => $expectation) {
            $entity = $expectation[0];

            if (is_string($entity->value)) {
                $data[$entity->value . ' #' . $index] = $expectation;
            } else {
                $data[] = $expectation;
            }
        }

        return $data;
    }

    #[DataProvider('data')]
    public function testTransform(TransformerExpectationEntity $entity): void
    {
        $transformer = $this->getTransformer($entity);
        $this->assertValue($transformer, $entity);
        $this->assertEquals($entity->expectBeforeValidation, $transformer->beforeValidation($entity->value, 'test'));
    }

    public function assertValue(TransformerContract $transformer, TransformerExpectationEntity $entity): void
    {
        $data = new GetValue(new ArrayData([
            'test' => $entity->value,
        ]));

        $transforms = [$transformer];

        if ($entity->expectException !== null) {
            $this->expectException($entity->expectException);
        }

        $result = $this->action->execute($data, ValueType::Array, 'test', [$this->wasCalledRule], $transforms);

        if ($entity->expectException !== null) {
            return;
        }

        $this->assertEquals($entity->expectedValue, $result, 'Result value does not match');

        if ($entity->expectedValue === null) {
            $this->assertEquals(
                false,
                $this->wasCalledRule->wasCalled,
                'Rule validation should be not called if value is null',
            );
        } else {
            $this->assertEquals(
                true,
                $this->wasCalledRule->wasCalled,
                'Rule validation should be called if value is not null',
            );
            $this->assertEquals(
                $entity->expectedValueBeforeValidation,
                $this->wasCalledRule->wasCalledWithValue,
                'Rule should have received different value',
            );
        }
    }

    abstract protected function getTransformer(TransformerExpectationEntity $entity): TransformerContract;
}

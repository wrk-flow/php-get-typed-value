<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Transformers;

use PHPUnit\Framework\TestCase;
use Wrkflow\GetValue\Actions\GetValidatedValueAction;
use Wrkflow\GetValue\Actions\ValidateAction;
use Wrkflow\GetValue\Builders\ExceptionBuilder;
use Wrkflow\GetValue\DataHolders\ArrayData;
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
     * @return array<array<TransformerExpectationEntity>>
     */
    abstract public function dataToTest(): array;

    public function data(): array
    {
        $data = [];

        foreach ($this->dataToTest() as $index => $expectation) {
            $this->assertNotEmpty($expectation);

            $entity = $expectation[0];

            if (is_string($entity->value)) {
                $data[$entity->value . ' #' . $index] = $expectation;
            } else {
                $data[] = $expectation;
            }
        }

        return $data;
    }

    /**
     * @dataProvider data
     */
    public function testTransform(TransformerExpectationEntity $entity): void
    {
        $this->assertValue($entity);
    }

    public function assertValue(TransformerExpectationEntity $entity): void
    {
        $data = new GetValue(new ArrayData([
            'test' => $entity->value,
        ]));

        $transforms = [$entity->transformer];

        if ($entity->expectException !== null) {
            $this->expectException($entity->expectException);
        }

        $result = $this->action->execute($data, 'test', [$this->wasCalledRule], $transforms);

        if ($entity->expectException !== null) {
            return;
        }

        $this->assertEquals($entity->expectedValue, $result, 'Result value does not match');

        if ($entity->expectedValue === null) {
            $this->assertEquals(
                expected: false,
                actual: $this->wasCalledRule->wasCalled,
                message: 'Rule validation should be not called if value is null'
            );
        } else {
            $this->assertEquals(
                expected: true,
                actual: $this->wasCalledRule->wasCalled,
                message: 'Rule validation should be called if value is not null'
            );
            $this->assertEquals(
                expected: $entity->expectedValueBeforeValidation,
                actual: $this->wasCalledRule->wasCalledWithValue,
                message: 'Rule should have received different value'
            );
        }
    }
}

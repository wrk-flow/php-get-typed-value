<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests;

use Wrkflow\GetValue\Contracts\RuleContract;
use Wrkflow\GetValue\Exceptions\AbstractGetValueException;
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\Strategies\NoTransformerStrategy;

abstract class AbstractArrayTestsTestCase extends AbstractArrayTestCase
{
    abstract public function requiredData(): array;

    /**
     * @dataProvider requiredData
     *
     * @param class-string<AbstractGetValueException>|null $expectedException
     * @param array<RuleContract>                          $rules
     */
    public function testRequired(
        string|array $key,
        mixed $expectedValue = null,
        ?string $expectedException = null,
        array $rules = []
    ): void {
        $data = $this->getBaseData($expectedException, $key);

        $value = $this->getRequiredValue($data, $rules);

        if ($expectedException === null) {
            $this->assertEquals($expectedValue, $value);
        }
    }

    abstract public function optionalData(): array;

    /**
     * @dataProvider optionalData
     *
     * @param class-string<AbstractGetValueException>|null $expectedException
     * @param array<RuleContract>                          $rules
     */
    public function testOptional(
        string|array $key,
        mixed $expectedValue = null,
        ?string $expectedException = null,
        array $rules = []
    ): void {
        $data = $this->getBaseData($expectedException, $key);

        $value = $this->getOptionalValue($data, $rules);

        if ($expectedException === null) {
            $this->assertEquals($expectedValue, $value);
        }
    }

    abstract public function noStrategyData(): array;

    /**
     * @dataProvider noStrategyData
     *
     * @param class-string<AbstractGetValueException>|null $expectedException
     * @param array<RuleContract>                          $rules
     */
    public function testOptionalNoStrategy(
        string|array $key,
        mixed $expectedValue = null,
        ?string $expectedException = null,
        array $rules = []
    ): void {
        $this->data = new GetValue(data: $this->arrayData, transformerStrategy: new NoTransformerStrategy());

        $data = $this->getBaseData($expectedException, $key);

        $value = $this->getOptionalValue($data, $rules);

        if ($expectedException === null) {
            // We cant check object references - use equals
            // Otherwise always check same type and same value
            if (is_object($value)) {
                $this->assertEquals($expectedValue, $value);
            } else {
                $this->assertSame($expectedValue, $value);
            }
        }
    }

    /**
     * @param class-string<AbstractGetValueException>|null $expectedException
     */
    protected function getBaseData(?string $expectedException, string|array $key): GetValue
    {
        if ($expectedException !== null) {
            $this->expectException($expectedException);
        }

        return $this->data->getRequiredArrayGetter($key);
    }

    /**
     * @param array<RuleContract> $rules
     */
    abstract protected function getRequiredValue(GetValue $data, array $rules): mixed;

    abstract protected function getOptionalValue(GetValue $data, array $rules): mixed;
}

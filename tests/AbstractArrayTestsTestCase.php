<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests;

use Wrkflow\GetValue\Contracts\RuleContract;
use Wrkflow\GetValue\Exceptions\AbstractGetValueException;
use Wrkflow\GetValue\GetValue;

abstract class AbstractArrayTestsTestCase extends AbstractArrayTestCase
{
    abstract public function requiredData(): array;

    /**
     * @dataProvider requiredData
     * @param class-string<AbstractGetValueException>|null $expectedException
     * @param array<RuleContract> $rules
     */
    public function testRequired(
        string $key,
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
     * @param class-string<AbstractGetValueException>|null $expectedException
     * @param array<RuleContract> $rules
     */
    public function testOptional(
        string $key,
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

    /**
     * @param class-string<AbstractGetValueException>|null $expectedException
     */
    protected function getBaseData(?string $expectedException, string $key): GetValue
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

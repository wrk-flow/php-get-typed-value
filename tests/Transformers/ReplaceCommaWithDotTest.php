<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Transformers;

use Wrkflow\GetValue\Contracts\TransformerContract;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\Transformers\ReplaceCommaWithDot;

class ReplaceCommaWithDotTest extends AbstractTransformerTestCase
{
    public function dataToTest(): array
    {
        // Expects before validation to be set true to ensure numeric rule will succeed
        return [
            [new TransformerExpectationEntity(value: '', expectedValue: '', expectBeforeValidation: true)],
            [new TransformerExpectationEntity(value: ' ', expectedValue: ' ', expectBeforeValidation: true)],
            [new TransformerExpectationEntity(value: ' asd ', expectedValue: ' asd ', expectBeforeValidation: true)],
            [new TransformerExpectationEntity(value: '200', expectedValue: '200', expectBeforeValidation: true)],
            [new TransformerExpectationEntity(value: '200.01', expectedValue: '200.01', expectBeforeValidation: true)],
            [new TransformerExpectationEntity(value: '200,01', expectedValue: '200.01', expectBeforeValidation: true)],
            [
                new TransformerExpectationEntity(
                    value: 'test, something',
                    expectedValue: 'test. something',
                    expectBeforeValidation: true
                ),
            ],
        ];
    }

    public function testDocumentationExample(): void
    {
        $data = new GetValue(new ArrayData([
            'key' => '1200,50',
        ]));
        $value = $data->getFloat('key');
        $this->assertEquals(1200.50, $value);
        $string = $data->getString('key', transformers: [new ReplaceCommaWithDot()]);
        $this->assertEquals('1200.50', $string);
    }

    protected function getTransformer(TransformerExpectationEntity $entity): TransformerContract
    {
        return new ReplaceCommaWithDot();
    }
}

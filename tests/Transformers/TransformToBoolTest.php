<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Transformers;

use Wrkflow\GetValue\Contracts\TransformerContract;
use Wrkflow\GetValue\Transformers\TransformToBool;

class TransformToBoolTest extends AbstractTransformerTestCase
{
    public function dataToTest(): array
    {
        return [
            [new TransformerExpectationEntity(value: 'yes', expectedValue: true, expectBeforeValidation: true)],
            [new TransformerExpectationEntity(value: 'true', expectedValue: true, expectBeforeValidation: true)],
            [new TransformerExpectationEntity(value: true, expectedValue: true, expectBeforeValidation: true)],
            [new TransformerExpectationEntity(value: 1, expectedValue: true, expectBeforeValidation: true)],
            [new TransformerExpectationEntity(value: '1', expectedValue: true, expectBeforeValidation: true)],
            [new TransformerExpectationEntity(value: 'no', expectedValue: false, expectBeforeValidation: true)],
            [new TransformerExpectationEntity(value: 'false', expectedValue: false, expectBeforeValidation: true)],
            [new TransformerExpectationEntity(value: false, expectedValue: false, expectBeforeValidation: true)],
            [new TransformerExpectationEntity(value: 0, expectedValue: false, expectBeforeValidation: true)],
            [new TransformerExpectationEntity(value: '0', expectedValue: false, expectBeforeValidation: true)],
            // Do not alter if diff value (rule validation will kick in).
            [new TransformerExpectationEntity(value: '', expectedValue: '', expectBeforeValidation: true)],
            [new TransformerExpectationEntity(value: ' ', expectedValue: ' ', expectBeforeValidation: true)],
            [new TransformerExpectationEntity(value: ' yes ', expectedValue: ' yes ', expectBeforeValidation: true)],
            [new TransformerExpectationEntity(value: 'no mix', expectedValue: 'no mix', expectBeforeValidation: true)],
            [
                new TransformerExpectationEntity(
                    value: 'yes mix',
                    expectedValue: 'yes mix',
                    expectBeforeValidation: true
                ),
            ],
            [new TransformerExpectationEntity(value: '2', expectedValue: '2', expectBeforeValidation: true)],
            [new TransformerExpectationEntity(value: '1 2 3', expectedValue: '1 2 3', expectBeforeValidation: true)],
            [
                new TransformerExpectationEntity(
                    value: '0 1 2 3',
                    expectedValue: '0 1 2 3',
                    expectBeforeValidation: true
                ),
            ],
        ];
    }

    protected function getTransformer(): TransformerContract
    {
        return new TransformToBool();
    }
}

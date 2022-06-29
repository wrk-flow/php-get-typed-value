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
            [new TransformerExpectationEntity(value: 'yes', expectedValue: true)],
            [new TransformerExpectationEntity(value: 'true', expectedValue: true)],
            [new TransformerExpectationEntity(value: true, expectedValue: true)],
            [new TransformerExpectationEntity(value: 1, expectedValue: true)],
            [new TransformerExpectationEntity(value: '1', expectedValue: true)],
            [new TransformerExpectationEntity(value: 'no', expectedValue: false)],
            [new TransformerExpectationEntity(value: 'false', expectedValue: false)],
            [new TransformerExpectationEntity(value: false, expectedValue: false)],
            [new TransformerExpectationEntity(value: 0, expectedValue: false)],
            [new TransformerExpectationEntity(value: '0', expectedValue: false)],
            // Do not alter if diff value (rule validation will kick in).
            [new TransformerExpectationEntity(value: '', expectedValue: '')],
            [new TransformerExpectationEntity(value: ' ', expectedValue: ' ')],
            [new TransformerExpectationEntity(value: ' yes ', expectedValue: ' yes ')],
            [new TransformerExpectationEntity(value: 'no mix', expectedValue: 'no mix')],
            [new TransformerExpectationEntity(value: 'yes mix', expectedValue: 'yes mix')],
            [new TransformerExpectationEntity(value: '2', expectedValue: '2')],
            [new TransformerExpectationEntity(value: '1 2 3', expectedValue: '1 2 3')],
            [new TransformerExpectationEntity(value: '0 1 2 3', expectedValue: '0 1 2 3')],
        ];
    }

    protected function getTransformer(): TransformerContract
    {
        return new TransformToBool();
    }
}

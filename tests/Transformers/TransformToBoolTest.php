<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Transformers;

use Wrkflow\GetValue\Transformers\TransformToBool;

class TransformToBoolTest extends AbstractTransformerTestCase
{
    public function dataToTest(): array
    {
        $transformer = new TransformToBool();

        return [
            [new TransformerExpectationEntity(value: 'yes', transformer: $transformer, expectedValue: true)],
            [new TransformerExpectationEntity(value: 'true', transformer: $transformer, expectedValue: true)],
            [new TransformerExpectationEntity(value: true, transformer: $transformer, expectedValue: true)],
            [new TransformerExpectationEntity(value: 1, transformer: $transformer, expectedValue: true)],
            [new TransformerExpectationEntity(value: '1', transformer: $transformer, expectedValue: true)],
            [new TransformerExpectationEntity(value: 'no', transformer: $transformer, expectedValue: false)],
            [new TransformerExpectationEntity(value: 'false', transformer: $transformer, expectedValue: false)],
            [new TransformerExpectationEntity(value: false, transformer: $transformer, expectedValue: false)],
            [new TransformerExpectationEntity(value: 0, transformer: $transformer, expectedValue: false)],
            [new TransformerExpectationEntity(value: '0', transformer: $transformer, expectedValue: false)],
            // Do not alter if diff value (rule validation will kick in).
            [new TransformerExpectationEntity(value: '', transformer: $transformer, expectedValue: '')],
            [new TransformerExpectationEntity(value: ' ', transformer: $transformer, expectedValue: ' ')],
            [new TransformerExpectationEntity(value: ' yes ', transformer: $transformer, expectedValue: ' yes ')],
            [new TransformerExpectationEntity(value: 'no mix', transformer: $transformer, expectedValue: 'no mix')],
            [new TransformerExpectationEntity(value: 'yes mix', transformer: $transformer, expectedValue: 'yes mix')],
            [new TransformerExpectationEntity(value: '2', transformer: $transformer, expectedValue: '2')],
            [new TransformerExpectationEntity(value: '1 2 3', transformer: $transformer, expectedValue: '1 2 3')],
            [new TransformerExpectationEntity(value: '0 1 2 3', transformer: $transformer, expectedValue: '0 1 2 3')],
        ];
    }
}

<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Transformers;

use Wrkflow\GetValue\Transformers\TrimAndEmptyStringToNull;

class TrimAndEmptyStringToNullTest extends AbstractTransformerTestCase
{
    public function dataToTest(): array
    {
        $transformer = new TrimAndEmptyStringToNull();

        return [
            [new TransformerExpectationEntity(value: '', transformer: $transformer, expectedValue: null)],
            [new TransformerExpectationEntity(value: ' ', transformer: $transformer, expectedValue: null)],
            [new TransformerExpectationEntity(value: ' asd ', transformer: $transformer, expectedValue: 'asd')],
            [new TransformerExpectationEntity(value: 'asd ', transformer: $transformer, expectedValue: 'asd')],
            [new TransformerExpectationEntity(value: 'asd mix', transformer: $transformer, expectedValue: 'asd mix')],
        ];
    }
}

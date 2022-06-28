<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Transformers;

use Wrkflow\GetValue\Transformers\TrimString;

class TrimStringTest extends AbstractTransformerTestCase
{
    public function dataToTest(): array
    {
        $transformer = new TrimString();

        return [
            [new TransformerExpectationEntity(value: '', transformer: $transformer, expectedValue: '')],
            [new TransformerExpectationEntity(value: ' ', transformer: $transformer, expectedValue: '')],
            [new TransformerExpectationEntity(value: ' asd ', transformer: $transformer, expectedValue: 'asd')],
            [new TransformerExpectationEntity(value: 'asd ', transformer: $transformer, expectedValue: 'asd')],
            [new TransformerExpectationEntity(value: 'asd mix', transformer: $transformer, expectedValue: 'asd mix')],
        ];
    }
}

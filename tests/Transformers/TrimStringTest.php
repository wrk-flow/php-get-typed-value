<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Transformers;

use Wrkflow\GetValue\Contracts\TransformerContract;
use Wrkflow\GetValue\Transformers\TrimString;

class TrimStringTest extends AbstractTransformerTestCase
{
    public function dataToTest(): array
    {
        return [
            [new TransformerExpectationEntity(value: '', expectedValue: '')],
            [new TransformerExpectationEntity(value: ' ', expectedValue: '')],
            [new TransformerExpectationEntity(value: ' asd ', expectedValue: 'asd')],
            [new TransformerExpectationEntity(value: 'asd ', expectedValue: 'asd')],
            [new TransformerExpectationEntity(value: 'asd mix', expectedValue: 'asd mix')],
        ];
    }

    protected function getTransformer(): TransformerContract
    {
        return new TrimString();
    }
}

<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Transformers;

use Wrkflow\GetValue\Contracts\TransformerContract;
use Wrkflow\GetValue\Transformers\TrimString;

class TrimStringTest extends AbstractTransformerTestCase
{
    /**
     * @return array<array-key, array<int, TransformerExpectationEntity>>
     */
    public static function dataToTest(): array
    {
        return [
            [new TransformerExpectationEntity(value: '', expectedValue: '', expectBeforeValidation: true)],
            [new TransformerExpectationEntity(value: ' ', expectedValue: '', expectBeforeValidation: true)],
            [new TransformerExpectationEntity(value: ' asd ', expectedValue: 'asd', expectBeforeValidation: true)],
            [new TransformerExpectationEntity(value: 'asd ', expectedValue: 'asd', expectBeforeValidation: true)],
            [
                new TransformerExpectationEntity(
                    value: 'asd mix',
                    expectedValue: 'asd mix',
                    expectBeforeValidation: true,
                ),
            ],
        ];
    }

    protected function getTransformer(TransformerExpectationEntity $entity): TransformerContract
    {
        return new TrimString();
    }
}

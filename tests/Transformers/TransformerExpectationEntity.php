<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Transformers;

use Wrkflow\GetValue\Contracts\TransformerContract;

class TransformerExpectationEntity
{
    public readonly mixed $expectedValueBeforeValidation;

    public function __construct(
        public readonly  mixed $value,
        public readonly TransformerContract $transformer,
        public readonly mixed $expectedValue,
        mixed $expectedValueBeforeValidation = null
    ) {
        $this->expectedValueBeforeValidation = $expectedValueBeforeValidation ?? $expectedValue;
    }
}

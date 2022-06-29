<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Transformers;

use Exception;

class TransformerExpectationEntity
{
    public readonly mixed $expectedValueBeforeValidation;

    /**
     * @param class-string<Exception>|null $expectException
     */
    public function __construct(
        public readonly mixed $value,
        public readonly mixed $expectedValue,
        mixed $expectedValueBeforeValidation = null,
        public readonly ?string $expectException = null
    ) {
        $this->expectedValueBeforeValidation = $expectedValueBeforeValidation ?? $expectedValue;
    }
}

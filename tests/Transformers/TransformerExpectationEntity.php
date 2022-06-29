<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Transformers;

use Exception;
use Wrkflow\GetValue\Contracts\TransformerContract;

class TransformerExpectationEntity
{
    public readonly mixed $expectedValueBeforeValidation;

    /**
     * @param mixed                        $value
     * @param TransformerContract          $transformer
     * @param mixed                        $expectedValue
     * @param class-string<Exception>|null $expectException
     */
    public function __construct(
        public readonly  mixed $value,
        public readonly TransformerContract $transformer,
        public readonly mixed $expectedValue,
        mixed $expectedValueBeforeValidation = null,
        public readonly ?string $expectException = null
    ) {
        $this->expectedValueBeforeValidation = $expectedValueBeforeValidation ?? $expectedValue;
    }
}

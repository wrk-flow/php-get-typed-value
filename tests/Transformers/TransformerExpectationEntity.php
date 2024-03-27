<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Transformers;

use Exception;

class TransformerExpectationEntity
{
    public readonly mixed $expectedValueBeforeValidation;

    /**
     * @var array<string>
     */
    public array $expectedKey;

    /**
     * @param class-string<Exception>|null $expectException
     * @param string|array<string> $expectedKey Pass a list of keys that is expected to be called.
     */
    public function __construct(
        public readonly mixed $value,
        public readonly mixed $expectedValue,
        mixed $expectedValueBeforeValidation = null,
        public readonly ?string $expectException = null,
        public readonly bool $expectBeforeValidation = false,
        string|array $expectedKey = '',
    ) {
        $this->expectedKey = is_array($expectedKey) ? $expectedKey : [$expectedKey];
        $this->expectedValueBeforeValidation = $expectedValueBeforeValidation ?? $expectedValue;
    }
}

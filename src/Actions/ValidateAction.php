<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Actions;

use Wrkflow\GetValue\Contracts\ExceptionBuilderContract;

class ValidateAction
{
    public function __construct(
        private readonly ExceptionBuilderContract $exceptionBuilder,
    ) {
    }

    public function execute(array $rules, mixed $value, string $key): void
    {
        foreach ($rules as $rule) {
            if ($rule->passes($value) === false) {
                throw $this->exceptionBuilder->validationFailed($key, $rule::class);
            }
        }
    }
}

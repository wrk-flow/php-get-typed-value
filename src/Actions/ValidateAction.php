<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Actions;

use Wrkflow\GetValue\Contracts\ExceptionBuilderContract;

class ValidateAction
{
    private const MaxStringLength = 30;

    public function __construct(
        private readonly ExceptionBuilderContract $exceptionBuilder,
    ) {
    }

    public function execute(array $rules, mixed $value, string $key): void
    {
        if ($value === '') {
            $valueForLog = '(empty string)';
        } elseif (is_string($value) || is_numeric($value)) {
            // Length does not need to be exact (no need for ext-mbstring)
            $valueForLog = (string) $value;
            if (strlen($valueForLog) > self::MaxStringLength) {
                $valueForLog = substr($valueForLog, 0, self::MaxStringLength - 3) . '...';
            }
        } elseif ($value === null) {
            $valueForLog = '(null)';
        } elseif (is_array($value)) {
            $valueForLog = '(array with count ' . count($value) . ')';
        } else {
            $valueForLog = null;
        }

        foreach ($rules as $rule) {
            if ($rule->passes($value) === false) {
                throw $this->exceptionBuilder->validationFailed($key, $rule::class, $valueForLog);
            }
        }
    }
}

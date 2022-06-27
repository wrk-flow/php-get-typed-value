<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Actions;

use Wrkflow\GetValue\Contracts\ExceptionBuilderContract;
use Wrkflow\GetValue\Contracts\RuleContract;
use Wrkflow\GetValue\DataHolders\AbstractData;

class GetValidatedValueAction
{
    public function __construct(protected readonly ExceptionBuilderContract $exceptionBuilder)
    {
    }

    /**
     * @param array<RuleContract> $rules
     */
    public function execute(string $key, AbstractData $data, array $rules): mixed
    {
        $value = $data->getValue($key);

        if ($rules === []) {
            return $value;
        }

        // Skip validation on null value
        if ($value === null) {
            return $value;
        }

        foreach ($rules as $rule) {
            if ($rule->passes($value) === false) {
                throw $this->exceptionBuilder->validationFailed($key, $rule::class);
            }
        }

        return $value;
    }
}

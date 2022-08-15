<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Actions;

use Wrkflow\GetValue\Contracts\RuleContract;
use Wrkflow\GetValue\Contracts\TransformerContract;
use Wrkflow\GetValue\Enums\ValueType;
use Wrkflow\GetValue\GetValue;

class GetValidatedValueAction
{
    public function __construct(
        private readonly ValidateAction $validateAction
    ) {
    }

    /**
     * @param array<RuleContract>        $rules
     * @param array<TransformerContract> $transforms
     */
    public function execute(
        GetValue $getValue,
        ValueType $valueType,
        string|array $key,
        array $rules,
        array $transforms,
    ): mixed {
        $fullKey = $getValue->data->getKey($key);
        $value = $getValue->data->getValue($key, $valueType);

        $afterValidationTransforms = [];

        foreach ($transforms as $transform) {
            if ($rules === [] || $transform->beforeValidation(value: $value, key: $fullKey)) {
                $value = $transform->transform(value: $value, key: $fullKey, getValue: $getValue);
            } else {
                $afterValidationTransforms[] = $transform;
            }
        }

        if ($rules === []) {
            return $value;
        }

        // Do not run validation on null
        if ($value === null) {
            return null;
        }

        $this->validateAction->execute(rules: $rules, value: $value, key: $fullKey);

        foreach ($afterValidationTransforms as $transform) {
            $value = $transform->transform(value: $value, key: $fullKey, getValue: $getValue);
        }

        return $value;
    }
}

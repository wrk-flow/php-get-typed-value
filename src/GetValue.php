<?php

declare(strict_types=1);

namespace Wrkflow\GetValue;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Wrkflow\GetValue\Actions\GetValidatedValueAction;
use Wrkflow\GetValue\Builders\ExceptionBuilder;
use Wrkflow\GetValue\Contracts\ExceptionBuilderContract;
use Wrkflow\GetValue\Contracts\RuleContract;
use Wrkflow\GetValue\DataHolders\AbstractData;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\Rules\BooleanRule;
use Wrkflow\GetValue\Rules\NumericRule;
use Wrkflow\GetValue\Rules\StringRule;

class GetValue
{
    public readonly GetValidatedValueAction $getValidatedValueAction;

    public function __construct(
        public readonly AbstractData $data,
        public readonly ExceptionBuilderContract $exceptionBuilder = new ExceptionBuilder(),
        GetValidatedValueAction $getValidatedValueAction = null
    ) {
        $this->getValidatedValueAction = $getValidatedValueAction ?? new GetValidatedValueAction(
            $this->exceptionBuilder
        );
    }

    /**
     * @param array<RuleContract> $rules
     */
    public function getInt(string $key, array $rules = []): ?int
    {
        $value = $this->getValidatedValue($key, $rules, new NumericRule());

        if ($value === null || $value === '') {
            return null;
        }

        return (int) $value;
    }

    /**
     * @param array<RuleContract> $rules
     */
    public function getRequiredInt(string $key, array $rules = []): int
    {
        $value = $this->getInt($key, $rules);

        if ($value === null) {
            throw $this->exceptionBuilder->missingValue($key);
        }

        return $value;
    }

    /**
     * @param array<RuleContract> $rules
     */
    public function getFloat(string $key, array $rules = []): ?float
    {
        $value = $this->getValidatedValue($key, $rules, new NumericRule());

        if ($value === null || $value === '') {
            return null;
        }

        return floatval($value);
    }

    /**
     * @param array<RuleContract> $rules
     */
    public function getRequiredFloat(string $key, array $rules = []): float
    {
        $value = $this->getFloat($key, $rules);

        if ($value === null) {
            throw $this->exceptionBuilder->missingValue($key);
        }

        return $value;
    }

    /**
     * @param array<RuleContract> $rules
     */
    public function getBool(string $key, array $rules = []): ?bool
    {
        $value = $this->getValidatedValue($key, $rules, new BooleanRule());

        if ($value === null || $value === '') {
            return null;
        }

        return boolval($value);
    }

    /**
     * @param array<RuleContract> $rules
     */
    public function getRequiredBool(string $key, array $rules = []): bool
    {
        $value = $this->getBool($key, $rules);

        if ($value === null) {
            throw $this->exceptionBuilder->missingValue($key);
        }

        return $value;
    }

    /**
     * @param array<RuleContract> $rules
     */
    public function getString(string $key, array $rules = []): ?string
    {
        $value = $this->getValidatedValue($key, $rules, new StringRule());

        if ($value === null) {
            return null;
        }

        return (string) $value;
    }

    /**
     * @param array<RuleContract> $rules
     */
    public function getRequiredString(string $key, array $rules = []): string
    {
        $value = $this->getString($key, $rules);

        if ($value === null) {
            throw  $this->exceptionBuilder->missingValue($key);
        }

        return $value;
    }

    /**
     * @param array<RuleContract> $rules
     *
     * @return DateTime|DateTimeImmutable|null
     */
    public function getDateTime(string $key, array $rules = []): ?DateTimeInterface
    {
        $value = $this->getValidatedValue($key, $rules, new StringRule());

        if ($value === null || $value === '') {
            return null;
        }

        return new DateTime($value);
    }

    /**
     * @param array<RuleContract> $rules
     *
     * @return DateTime|DateTimeImmutable
     */
    public function getRequiredDateTime(string $key, array $rules = []): DateTimeInterface
    {
        $value = $this->getDateTime($key, $rules);

        if ($value instanceof DateTime === false) {
            throw $this->exceptionBuilder->missingValue($key);
        }

        return $value;
    }

    /**
     * Ensures that always an array will be returned (if missing in $data or if null).
     */
    public function getArray(string $key): array
    {
        $value = $this->getValidatedValue($key, []);

        if ($value === null) {
            return [];
        }

        if (is_array($value) === false) {
            throw $this->exceptionBuilder->notAnArray($key);
        }

        return $value;
    }

    /**
     * Ensures that always an array will be returned (if missing in $data or if null).
     */
    public function getNullableArray(string $key): ?array
    {
        $value = $this->getValidatedValue($key, []);

        if ($value === null) {
            return null;
        }

        if (is_array($value) === false) {
            throw $this->exceptionBuilder->notAnArray($key);
        }

        return $value;
    }

    /**
     * Checks if the array is in the data set with non-empty array
     *
     * @phpstan-return non-empty-array
     */
    public function getRequiredArray(string $key): array
    {
        $value = $this->getNullableArray($key);

        if ($value === [] || $value === null) {
            throw $this->exceptionBuilder->arrayIsEmpty($key);
        }

        return $value;
    }

    /**
     * Get always `GetValue` instance even if provided data is missing or if null.
     */
    public function getArrayGetter(string $key): self
    {
        return new self(new ArrayData($this->getArray($key)), $this->exceptionBuilder, $this->getValidatedValueAction);
    }

    /**
     * Try to get nullable array from data and wrap it in `GetValue` instance.
     */
    public function getNullableArrayGetter(string $key): ?self
    {
        $value = $this->getNullableArray($key);

        if ($value === null || $value === []) {
            return null;
        }

        return new self(new ArrayData($value), $this->exceptionBuilder, $this->getValidatedValueAction);
    }

    /**
     * Checks if the array is in the data set with non-empty array
     */
    public function getRequiredArrayGetter(string $key): self
    {
        $value = $this->getRequiredArray($key);

        return new self(new ArrayData($value), $this->exceptionBuilder, $this->getValidatedValueAction);
    }

    /**
     * @param RuleContract|null $mainRule Adds given rule before all given rules.
     */
    protected function getValidatedValue(string $key, array $rules, ?RuleContract $mainRule = null): mixed
    {
        if ($mainRule !== null) {
            $rules = array_merge([$mainRule], $rules);
        }

        return $this->getValidatedValueAction->execute($key, $this->data, $rules);
    }
}

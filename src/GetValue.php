<?php

declare(strict_types=1);

namespace Wrkflow\GetValue;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Wrkflow\GetValue\Actions\GetValidatedValueAction;
use Wrkflow\GetValue\Actions\ValidateAction;
use Wrkflow\GetValue\Builders\ExceptionBuilder;
use Wrkflow\GetValue\Contracts\ExceptionBuilderContract;
use Wrkflow\GetValue\Contracts\RuleContract;
use Wrkflow\GetValue\Contracts\TransformerArrayContract;
use Wrkflow\GetValue\Contracts\TransformerContract;
use Wrkflow\GetValue\Contracts\TransformerStrategy;
use Wrkflow\GetValue\DataHolders\AbstractData;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\Rules\BooleanRule;
use Wrkflow\GetValue\Rules\NumericRule;
use Wrkflow\GetValue\Rules\StringRule;
use Wrkflow\GetValue\Strategies\DefaultTransformerStrategy;

class GetValue
{
    public readonly GetValidatedValueAction $getValidatedValueAction;

    public function __construct(
        public readonly AbstractData $data,
        public readonly TransformerStrategy $transformerStrategy = new DefaultTransformerStrategy(),
        public readonly ExceptionBuilderContract $exceptionBuilder = new ExceptionBuilder(),
        GetValidatedValueAction $getValidatedValueAction = null,
    ) {
        $this->getValidatedValueAction = $getValidatedValueAction ?? new GetValidatedValueAction(
            new ValidateAction($this->exceptionBuilder)
        );
    }

    /**
     * @param array<RuleContract>        $rules
     * @param array<TransformerContract> $transformers
     */
    public function getInt(string $key, array $rules = [], ?array $transformers = null): ?int
    {
        $value = $this->getValidatedValue(
            key: $key,
            rules: $rules,
            mainRule: new NumericRule(),
            transformers: $transformers ?? $this->transformerStrategy->int()
        );

        if ($value === null || $value === '') {
            return null;
        }

        return (int) $value;
    }

    /**
     * @param array<RuleContract>        $rules
     * @param array<TransformerContract> $transformers
     */
    public function getRequiredInt(string $key, array $rules = [], ?array $transformers = null): int
    {
        $value = $this->getInt(key: $key, rules: $rules, transformers: $transformers);

        if ($value === null) {
            throw $this->exceptionBuilder->missingValue($key);
        }

        return $value;
    }

    /**
     * @param array<RuleContract>        $rules
     * @param array<TransformerContract> $transformers
     */
    public function getFloat(string $key, array $rules = [], ?array $transformers = null): ?float
    {
        $value = $this->getValidatedValue(
            key: $key,
            rules: $rules,
            mainRule: new NumericRule(),
            transformers: $transformers ?? $this->transformerStrategy->float()
        );

        if ($value === null || $value === '') {
            return null;
        }

        return floatval($value);
    }

    /**
     * @param array<RuleContract>        $rules
     * @param array<TransformerContract> $transformers
     */
    public function getRequiredFloat(string $key, array $rules = [], ?array $transformers = null): float
    {
        $value = $this->getFloat(key: $key, rules: $rules, transformers: $transformers);

        if ($value === null) {
            throw $this->exceptionBuilder->missingValue($key);
        }

        return $value;
    }

    /**
     * @param array<RuleContract>        $rules
     * @param array<TransformerContract> $transformers
     */
    public function getBool(string $key, array $rules = [], ?array $transformers = null): ?bool
    {
        $value = $this->getValidatedValue(
            key: $key,
            rules: $rules,
            mainRule: new BooleanRule(),
            transformers: $transformers ?? $this->transformerStrategy->bool()
        );

        if ($value === null || $value === '') {
            return null;
        }

        return boolval($value);
    }

    /**
     * @param array<RuleContract>        $rules
     * @param array<TransformerContract>|null $transformers
     */
    public function getRequiredBool(string $key, array $rules = [], ?array $transformers = null): bool
    {
        $value = $this->getBool(key: $key, rules: $rules, transformers: $transformers);

        if ($value === null) {
            throw $this->exceptionBuilder->missingValue($key);
        }

        return $value;
    }

    /**
     * @param array<RuleContract>        $rules
     * @param array<TransformerContract>|null $transformers
     */
    public function getString(string $key, array $rules = [], ?array $transformers = null): ?string
    {
        $value = $this->getValidatedValue(
            key: $key,
            rules: $rules,
            mainRule: new StringRule(),
            transformers: $transformers ?? $this->transformerStrategy->string()
        );

        if ($value === null) {
            return null;
        }

        return (string) $value;
    }

    /**
     * @param array<RuleContract>        $rules
     * @param array<TransformerContract>|null $transformers
     */
    public function getRequiredString(string $key, array $rules = [], ?array $transformers = null): string
    {
        $value = $this->getString(key: $key, rules: $rules, transformers: $transformers);

        if ($value === null) {
            throw  $this->exceptionBuilder->missingValue($key);
        }

        return $value;
    }

    /**
     * @param array<RuleContract>        $rules
     * @param array<TransformerContract>|null $transformers
     *
     * @return DateTime|DateTimeImmutable|null
     */
    public function getDateTime(string $key, array $rules = [], ?array $transformers = null): ?DateTimeInterface
    {
        $value = $this->getValidatedValue(
            key: $key,
            rules: $rules,
            mainRule: new StringRule(),
            transformers: $transformers ?? $this->transformerStrategy->dateTime()
        );

        if ($value === null || $value === '') {
            return null;
        }

        return new DateTime($value);
    }

    /**
     * @param array<RuleContract>        $rules
     * @param array<TransformerContract>|null $transformers
     *
     * @return DateTime|DateTimeImmutable
     */
    public function getRequiredDateTime(string $key, array $rules = [], ?array $transformers = null): DateTimeInterface
    {
        $value = $this->getDateTime(key: $key, rules: $rules, transformers: $transformers);

        if ($value instanceof DateTime === false) {
            throw $this->exceptionBuilder->missingValue($key);
        }

        return $value;
    }

    /**
     * Ensures that always an array will be returned (if missing in $data or if null).
     *
     * @param array<TransformerArrayContract>|null $transformers
     */
    public function getArray(string $key, ?array $transformers = null): array
    {
        $value = $this->getValidatedValue(
            key: $key,
            transformers: $transformers ?? $this->transformerStrategy->array(),
        );

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
     *
     * @param array<TransformerArrayContract>|null $transformers
     */
    public function getNullableArray(string $key, ?array $transformers = null): ?array
    {
        $value = $this->getValidatedValue(
            key: $key,
            transformers: $transformers ?? $this->transformerStrategy->array(),
        );

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
     * @param array<TransformerArrayContract>|null $transformers
     *
     * @phpstan-return non-empty-array
     */
    public function getRequiredArray(string $key, ?array $transformers = null): array
    {
        $value = $this->getNullableArray(key: $key, transformers: $transformers);

        if ($value === [] || $value === null) {
            throw $this->exceptionBuilder->arrayIsEmpty($key);
        }

        return $value;
    }

    /**
     * Get always `GetValue` instance even if provided data is missing or if null.
     *
     * @param array<TransformerArrayContract>|null $transformers
     */
    public function getArrayGetter(string $key, ?array $transformers = null): self
    {
        $data = new ArrayData($this->getArray($key, $transformers));

        return $this->makeInstance($data);
    }

    /**
     * Try to get nullable array from data and wrap it in `GetValue` instance.
     *
     * @param array<TransformerArrayContract>|null $transformers
     */
    public function getNullableArrayGetter(string $key, ?array $transformers = null): ?self
    {
        $value = $this->getNullableArray(key: $key, transformers: $transformers);

        if ($value === null || $value === []) {
            return null;
        }

        return $this->makeInstance(new ArrayData($value));
    }

    /**
     * Checks if the array is in the data set with non-empty array
     *
     * @param array<TransformerArrayContract>|null $transformers
     */
    public function getRequiredArrayGetter(string $key, ?array $transformers = null): self
    {
        $value = $this->getRequiredArray(key: $key, transformers: $transformers);

        return $this->makeInstance(new ArrayData($value));
    }

    /**
     * @param array<RuleContract>        $rules
     * @param RuleContract|null          $mainRule Adds given rule before all given rules.
     * @param array<TransformerContract> $transformers
     */
    protected function getValidatedValue(
        string $key,
        array $rules = [],
        ?RuleContract $mainRule = null,
        array $transformers = [],
    ): mixed {
        if ($mainRule !== null) {
            $rules = array_merge([$mainRule], $rules);
        }

        return $this->getValidatedValueAction->execute($this->data, $key, $rules, $transformers);
    }

    protected function makeInstance(AbstractData $data): self
    {
        return new self(
            data: $data,
            transformerStrategy: $this->transformerStrategy,
            exceptionBuilder: $this->exceptionBuilder,
            getValidatedValueAction: $this->getValidatedValueAction
        );
    }
}

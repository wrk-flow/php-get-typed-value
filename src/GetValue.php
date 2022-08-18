<?php

declare(strict_types=1);

namespace Wrkflow\GetValue;

use BackedEnum;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use SimpleXMLElement;
use TypeError;
use UnitEnum;
use Wrkflow\GetValue\Actions\GetValidatedValueAction;
use Wrkflow\GetValue\Actions\ValidateAction;
use Wrkflow\GetValue\Builders\ExceptionBuilder;
use Wrkflow\GetValue\Contracts\ExceptionBuilderContract;
use Wrkflow\GetValue\Contracts\GetValueTransformerContract;
use Wrkflow\GetValue\Contracts\RuleContract;
use Wrkflow\GetValue\Contracts\TransformerContract;
use Wrkflow\GetValue\Contracts\TransformerStrategy;
use Wrkflow\GetValue\DataHolders\AbstractData;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\DataHolders\XMLAttributesData;
use Wrkflow\GetValue\DataHolders\XMLData;
use Wrkflow\GetValue\Enums\ValueType;
use Wrkflow\GetValue\Rules\BooleanRule;
use Wrkflow\GetValue\Rules\EnumRule;
use Wrkflow\GetValue\Rules\NumericRule;
use Wrkflow\GetValue\Rules\StringRule;
use Wrkflow\GetValue\Strategies\DefaultTransformerStrategy;
use Wrkflow\GetValue\Transformers\GetterTransformer;

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
    public function getInt(string|array $key, array $rules = [], ?array $transformers = null): ?int
    {
        $value = $this->getValidatedValue(
            valueType: ValueType::Int,
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
    public function getRequiredInt(string|array $key, array $rules = [], ?array $transformers = null): int
    {
        $value = $this->getInt(key: $key, rules: $rules, transformers: $transformers);

        if ($value === null) {
            throw $this->exceptionBuilder->missingValue($this->data->getKey($key));
        }

        return $value;
    }

    /**
     * @param array<RuleContract>        $rules
     * @param array<TransformerContract> $transformers
     */
    public function getFloat(string|array $key, array $rules = [], ?array $transformers = null): ?float
    {
        $value = $this->getValidatedValue(
            valueType: ValueType::Float,
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
    public function getRequiredFloat(string|array $key, array $rules = [], ?array $transformers = null): float
    {
        $value = $this->getFloat(key: $key, rules: $rules, transformers: $transformers);

        if ($value === null) {
            throw $this->exceptionBuilder->missingValue($this->data->getKey($key));
        }

        return $value;
    }

    /**
     * @param array<RuleContract>        $rules
     * @param array<TransformerContract> $transformers
     */
    public function getBool(string|array $key, array $rules = [], ?array $transformers = null): ?bool
    {
        $value = $this->getValidatedValue(
            valueType: ValueType::Bool,
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
     * @param array<RuleContract>             $rules
     * @param array<TransformerContract>|null $transformers
     */
    public function getRequiredBool(string|array $key, array $rules = [], ?array $transformers = null): bool
    {
        $value = $this->getBool(key: $key, rules: $rules, transformers: $transformers);

        if ($value === null) {
            throw $this->exceptionBuilder->missingValue($this->data->getKey($key));
        }

        return $value;
    }

    /**
     * @param array<RuleContract>             $rules
     * @param array<TransformerContract>|null $transformers
     */
    public function getString(string|array $key, array $rules = [], ?array $transformers = null): ?string
    {
        $value = $this->getValidatedValue(
            valueType: ValueType::String,
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
     * @param array<RuleContract>             $rules
     * @param array<TransformerContract>|null $transformers
     */
    public function getRequiredString(string|array $key, array $rules = [], ?array $transformers = null): string
    {
        $value = $this->getString(key: $key, rules: $rules, transformers: $transformers);

        if ($value === null) {
            throw  $this->exceptionBuilder->missingValue($this->data->getKey($key));
        }

        return $value;
    }

    /**
     * @template TEnum of BackedEnum
     *
     * @param class-string<TEnum>             $enum
     * @param array<RuleContract>             $rules
     * @param array<TransformerContract>|null $transformers
     *
     * @return TEnum|null
     */
    public function getEnum(string|array $key, string $enum, array $rules = [], ?array $transformers = null): ?UnitEnum
    {
        $value = $this->getString(key: $key, rules: $rules + [new EnumRule($enum)], transformers: $transformers);

        if ($value === null) {
            return null;
        }

        //At this moment I've not found a way to detect int/string enum
        try {
            return $enum::from($value);
        } catch (TypeError) {
            return $enum::from((int) $value);
        }
    }

    /**
     * @template TEnum of BackedEnum
     *
     * @param class-string<TEnum>             $enum
     * @param array<RuleContract>             $rules
     * @param array<TransformerContract>|null $transformers
     *
     * @return TEnum
     */
    public function getRequiredEnum(
        string|array $key,
        string $enum,
        array $rules = [],
        ?array $transformers = null
    ): UnitEnum {
        $value = $this->getEnum(key: $key, enum: $enum, rules: $rules, transformers: $transformers);

        if ($value instanceof BackedEnum === false) {
            throw  $this->exceptionBuilder->missingValue($this->data->getKey($key));
        }

        return $value;
    }

    /**
     * @param array<RuleContract>             $rules
     * @param array<TransformerContract>|null $transformers
     *
     * @return DateTime|DateTimeImmutable|null
     */
    public function getDateTime(string|array $key, array $rules = [], ?array $transformers = null): ?DateTimeInterface
    {
        $value = $this->getValidatedValue(
            valueType: ValueType::DateTime,
            key: $key,
            rules: $rules,
            mainRule: new StringRule(),
            transformers: $transformers ?? $this->transformerStrategy->dateTime()
        );

        if ($value === null || $value === '') {
            return null;
        }

        // Transformer built the date time
        if ($value instanceof DateTime) {
            return $value;
        }

        return new DateTime($value);
    }

    /**
     * @param array<RuleContract>             $rules
     * @param array<TransformerContract>|null $transformers
     *
     * @return DateTime|DateTimeImmutable
     */
    public function getRequiredDateTime(
        string|array $key,
        array $rules = [],
        ?array $transformers = null
    ): DateTimeInterface {
        $value = $this->getDateTime(key: $key, rules: $rules, transformers: $transformers);

        if ($value instanceof DateTime === false) {
            throw $this->exceptionBuilder->missingValue($this->data->getKey($key));
        }

        return $value;
    }

    /**
     * Ensures that always an array will be returned (if missing in $data or if null).
     *
     * @param array<TransformerContract>|null $transformers
     */
    public function getArray(string|array $key, ?array $transformers = null): array
    {
        $value = $this->getValidatedValue(
            valueType: ValueType::Array,
            key: $key,
            transformers: $transformers ?? $this->transformerStrategy->array()
        );

        if ($value === null) {
            return [];
        }

        if (is_array($value) === false) {
            throw $this->exceptionBuilder->notAnArray($this->data->getKey($key));
        }

        return $value;
    }

    /**
     * Ensures that always an array will be returned (if missing in $data or if null).
     *
     * @param array<TransformerContract>|null $transformers
     */
    public function getNullableArray(string|array $key, ?array $transformers = null): ?array
    {
        $value = $this->getValidatedValue(
            valueType: ValueType::Array,
            key: $key,
            transformers: $transformers ?? $this->transformerStrategy->array(),
        );

        if ($value === null) {
            return null;
        }

        if (is_array($value) === false) {
            throw $this->exceptionBuilder->notAnArray($this->data->getKey($key));
        }

        return $value;
    }

    /**
     * Checks if the array is in the data set with non-empty array
     *
     * @param array<TransformerContract>|null $transformers
     *
     * @phpstan-return non-empty-array
     */
    public function getRequiredArray(string|array $key, ?array $transformers = null): array
    {
        $value = $this->getNullableArray(key: $key, transformers: $transformers);

        if ($value === [] || $value === null) {
            throw $this->exceptionBuilder->arrayIsEmpty($this->data->getKey($key));
        }

        return $value;
    }

    /**
     * Get always `GetValue` instance even if provided data is missing or if null.
     *
     * @param array<TransformerContract>|null $transformers
     */
    public function getArrayGetter(string|array $key, ?array $transformers = null): self
    {
        $data = new ArrayData($this->getArray($key, $transformers), $this->data->getKey($key));

        return $this->makeInstance($data);
    }

    /**
     * Try to get nullable array from data and wrap it in `GetValue` instance.
     *
     * @param array<TransformerContract>|null $transformers
     */
    public function getNullableArrayGetter(string|array $key, ?array $transformers = null): ?self
    {
        $value = $this->getNullableArray(key: $key, transformers: $transformers);

        if ($value === null || $value === []) {
            return null;
        }

        return $this->makeInstance(new ArrayData($value, $this->data->getKey($key)));
    }

    /**
     * Checks if the array is in the data set with non-empty array
     *
     * @param array<TransformerContract>|null $transformers
     */
    public function getRequiredArrayGetter(string|array $key, ?array $transformers = null): self
    {
        $value = $this->getRequiredArray(key: $key, transformers: $transformers);

        return $this->makeInstance(new ArrayData($value, $this->data->getKey($key)));
    }

    /**
     * Ensures that always an array will be returned (if missing in $data or if null).
     *
     * @param array<TransformerContract>|null $transformers
     */
    public function getNullableXML(
        string|array $key,
        ?array $transformers = null,
        ValueType $valueType = ValueType::Object,
    ): ?SimpleXMLElement {
        $value = $this->getValidatedValue(
            valueType: $valueType,
            key: $key,
            transformers: $transformers ?? $this->transformerStrategy->xml()
        );

        if ($value === null) {
            return null;
        }

        if ($value instanceof SimpleXMLElement === false) {
            throw $this->exceptionBuilder->notXML($this->data->getKey($key));
        }

        return $value;
    }

    /**
     * Checks if the array is in the data set with non-empty array
     *
     * @param array<TransformerContract>|null $transformers
     */
    public function getRequiredXML(
        string|array $key,
        ?array $transformers = null,
        ValueType $valueType = ValueType::Object,
    ): SimpleXMLElement {
        $value = $this->getNullableXML(key: $key, transformers: $transformers, valueType: $valueType);

        if ($value instanceof SimpleXMLElement === false) {
            throw $this->exceptionBuilder->missingValue($this->data->getKey($key));
        }

        return $value;
    }

    /**
     * Get always `GetValue` instance even if provided data is missing or if null.
     *
     * @param array<TransformerContract>|null $transformers
     */
    public function getXMLGetter(string|array $key, ?array $transformers = null): self
    {
        $xml = $this->getNullableXML($key, $transformers) ?? new SimpleXMLElement('<root/>');

        $data = new XMLData($xml, $this->data->getKey($key));

        return $this->makeInstance($data);
    }

    /**
     * Try to get nullable array from data and wrap it in `GetValue` instance.
     *
     * @param array<TransformerContract>|null $transformers
     */
    public function getNullableXMLGetter(string|array $key, ?array $transformers = null): ?self
    {
        $value = $this->getNullableXML(key: $key, transformers: $transformers);

        if ($value instanceof SimpleXMLElement === false) {
            return null;
        }

        return $this->makeInstance(new XMLData($value, $this->data->getKey($key)));
    }

    /**
     * Checks if the array is in the data set with non-empty array
     *
     * @param array<TransformerContract>|null $transformers
     */
    public function getRequiredXMLGetter(string|array $key, ?array $transformers = null): self
    {
        $value = $this->getRequiredXML(key: $key, transformers: $transformers);

        return $this->makeInstance(new XMLData($value, $this->data->getKey($key)));
    }

    public function getXMLAttributesGetter(string|array|null $key = null, ?array $transformers = null): self
    {
        $value = $key === null ? $this->data->get() : $this->getRequiredXML(
            key: $key,
            transformers: $transformers,
            valueType: ValueType::XMLAttributes
        );

        if ($value instanceof SimpleXMLElement === false) {
            throw $this->exceptionBuilder->notXML($this->data->getKey());
        }

        $attributes = $value->attributes() ?? new SimpleXMLElement('<root/>');

        $parentKey = '@attributes';
        if (is_array($key)) {
            $parentKey = $key + [$parentKey];
        } elseif (is_string($key)) {
            $parentKey = $key . '.' . $parentKey;
        }

        return $this->makeInstance(new XMLAttributesData($attributes, $this->data->getKey($parentKey)));
    }

    /**
     * @template T of object
     * @param class-string<T>       $expectedClass
     *
     * @return T|null
     */
    public function getObject(
        string $expectedClass,
        string|array $key,
        GetValueTransformerContract $getValueTransformer
    ): ?object {
        $transformers = [new GetterTransformer($getValueTransformer)];
        $result = $this->getValidatedValue(ValueType::Object, $key, transformers: $transformers);

        if ($result instanceof $expectedClass) {
            return $result;
        }

        return null;
    }

    /**
     * @template T of object
     * @param class-string<T>       $expectedClass
     *
     * @return T
     */
    public function getRequiredObject(
        string $expectedClass,
        string|array $key,
        GetValueTransformerContract $getValueTransformer
    ): object {
        $result = $this->getObject($expectedClass, $key, $getValueTransformer);

        if ($result === null) {
            throw $this->exceptionBuilder->missingValue($this->data->getKey($key));
        }

        return $result;
    }

    public function makeInstance(AbstractData $data): self
    {
        return new self(
            data: $data,
            transformerStrategy: $this->transformerStrategy,
            exceptionBuilder: $this->exceptionBuilder,
            getValidatedValueAction: $this->getValidatedValueAction
        );
    }

    public function makeData(mixed $value, string $key): ?AbstractData
    {
        $data = null;
        if (is_array($value)) {
            $data = new ArrayData($value, $this->data->getKey($key));
        } elseif ($value instanceof SimpleXMLElement) {
            $data = new XMLData($value, $this->data->getKey($key));
        }

        return $data;
    }

    /**
     * @param array<RuleContract>        $rules
     * @param RuleContract|null          $mainRule Adds given rule before all given rules.
     * @param array<TransformerContract> $transformers
     */
    protected function getValidatedValue(
        ValueType $valueType,
        string|array $key,
        array $rules = [],
        ?RuleContract $mainRule = null,
        array $transformers = [],
    ): mixed {
        if ($mainRule !== null) {
            $rules = array_merge([$mainRule], $rules);
        }

        return $this->getValidatedValueAction->execute($this, $valueType, $key, $rules, $transformers);
    }
}

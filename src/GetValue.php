<?php

declare(strict_types=1);

namespace Wrkflow\GetValue;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Wrkflow\GetValue\Builders\ExceptionBuilder;
use Wrkflow\GetValue\Contracts\ExceptionBuilderContract;
use Wrkflow\GetValue\DataHolders\AbstractData;
use Wrkflow\GetValue\DataHolders\ArrayData;

class GetValue
{
    public function __construct(
        public readonly AbstractData $data,
        public readonly ExceptionBuilderContract $exceptionBuilder = new ExceptionBuilder()
    ) {
    }

    public function getInt(string $key): ?int
    {
        $value = $this->data->getValue($key);

        if ($value === null || $value === '') {
            return null;
        }

        return (int) $value;
    }

    public function getRequiredInt(string $key): int
    {
        $value = $this->getInt($key);

        if ($value === null) {
            throw $this->exceptionBuilder->missingValue($key);
        }

        return $value;
    }

    public function getFloat(string $key): ?float
    {
        $value = $this->data->getValue($key);

        if ($value === null || $value === '') {
            return null;
        }

        return floatval($value);
    }

    public function getRequiredFloat(string $key): float
    {
        $value = $this->getFloat($key);

        if ($value === null) {
            throw $this->exceptionBuilder->missingValue($key);
        }

        return $value;
    }

    public function getBool(string $key): ?bool
    {
        $value = $this->data->getValue($key);

        if ($value === null || $value === '') {
            return null;
        }

        return boolval($value);
    }

    public function getRequiredBool(string $key): bool
    {
        $value = $this->getBool($key);

        if ($value === null) {
            throw $this->exceptionBuilder->missingValue($key);
        }

        return $value;
    }

    public function getString(string $key): ?string
    {
        $value = $this->data->getValue($key);

        if ($value === null) {
            return null;
        }

        return (string) $value;
    }

    public function getRequiredString(string $key): string
    {
        $value = $this->getString($key);

        if ($value === null) {
            throw  $this->exceptionBuilder->missingValue($key);
        }

        return $value;
    }

    /**
     * @return DateTime|DateTimeImmutable|null
     */
    public function getDateTime(string $key): ?DateTimeInterface
    {
        $value = $this->data->getValue($key);

        if ($value === null || $value === '') {
            return null;
        }

        // TODO validate?
        return new DateTime($value);
    }

    /**
     * @return DateTime|DateTimeImmutable
     */
    public function getRequiredDateTime(string $key): DateTimeInterface
    {
        $value = $this->getDateTime($key);

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
        $value = $this->data->getValue($key);

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
        $value = $this->data->getValue($key);

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
        $value = $this->getArray($key);

        if ($value === []) {
            throw $this->exceptionBuilder->arrayIsEmpty($key);
        }

        return $value;
    }

    /**
     * Ensures that always an array getter will be returned (if missing in $data or if null).
     */
    public function getArrayGetter(string $key): ?self
    {
        $value = $this->getNullableArray($key);

        if ($value === null) {
            return null;
        }

        return new self(new ArrayData($value), $this->exceptionBuilder);
    }

    /**
     * Checks if the array is in the data set with non-empty array
     */
    public function getRequiredArrayGetter(string $key): self
    {
        $value = $this->getArrayGetter($key);

        if ($value instanceof self === false) {
            throw $this->exceptionBuilder->arrayIsEmpty($key);
        }

        return $value;
    }
}

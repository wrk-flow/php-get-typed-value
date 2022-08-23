<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Rules;

use BackedEnum;
use LogicException;
use TypeError;
use Wrkflow\GetValue\Contracts\RuleContract;

class EnumRule implements RuleContract
{
    /**
     * @param class-string<BackedEnum> $enum
     */
    public function __construct(private readonly string $enum)
    {
    }

    public function passes(mixed $value): bool
    {
        if (is_int($value) === false && is_string($value) === false) {
            return false;
        }

        if (enum_exists($this->enum) === false) {
            throw new LogicException(sprintf('Provided enum <%s> is not an enum or it does not exists.', $this->enum));
        }

        if (method_exists($this->enum, 'tryFrom') === false) {
            throw new LogicException(sprintf('Provided enum <%s> is not supported. Use string/int enum.', $this->enum));
        }

        // If we are using int enum, and we will receive "string" it will throw TypeError.
        try {
            return $this->enum::tryFrom($value) !== null;
        } catch (TypeError) {
            try {
                return $this->enum::tryFrom((int) $value) !== null;
            } catch (TypeError) {
                return false;
            }
        }
    }
}

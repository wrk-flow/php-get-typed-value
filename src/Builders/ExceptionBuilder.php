<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Builders;

use Exception;
use Wrkflow\GetValue\Contracts\ExceptionBuilderContract;
use Wrkflow\GetValue\Exceptions\ArrayIsEmptyException;
use Wrkflow\GetValue\Exceptions\MissingValueForKeyException;
use Wrkflow\GetValue\Exceptions\NotSupportedDataException;
use Wrkflow\GetValue\Exceptions\NotXMLException;
use Wrkflow\GetValue\Exceptions\ValidationFailedException;

class ExceptionBuilder implements ExceptionBuilderContract
{
    public function missingValue(string $key): Exception
    {
        return new MissingValueForKeyException($key);
    }

    public function arrayIsEmpty(string $key): Exception
    {
        return new ArrayIsEmptyException($key);
    }

    public function notAnArray(string $key): Exception
    {
        return new NotSupportedDataException($key);
    }

    public function validationFailed(string $key, string $ruleClassName, ?string $value): Exception
    {
        $classNameParts = explode('\\', $ruleClassName);
        $shortClassName = end($classNameParts);

        $valueMessage = $value === null ? '' : (' with value <' . $value . '>');
        return new ValidationFailedException($key, $shortClassName . ' failed' . $valueMessage);
    }

    public function notXML(string $key): Exception
    {
        return new NotXMLException($key);
    }
}

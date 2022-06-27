<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests;

use Exception;
use Wrkflow\GetValue\Contracts\ExceptionBuilderContract;

class CustomExceptionBuilder implements ExceptionBuilderContract
{
    public function missingValue(string $key): Exception
    {
        return new Exception('missingValue: ' . $key);
    }

    public function arrayIsEmpty(string $key): Exception
    {
        return new Exception('arrayIsEmpty: ' . $key);
    }

    public function notAnArray(string $key): Exception
    {
        return new Exception('notAnArray: ' . $key);
    }
}

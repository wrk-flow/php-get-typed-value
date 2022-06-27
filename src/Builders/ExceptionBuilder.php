<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Builders;

use Exception;
use Wrkflow\GetValue\Contracts\ExceptionBuilderContract;
use Wrkflow\GetValue\Exceptions\ArrayIsEmptyException;
use Wrkflow\GetValue\Exceptions\MissingValueForKeyException;
use Wrkflow\GetValue\Exceptions\NotAnArrayException;

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
        return new NotAnArrayException($key);
    }
}

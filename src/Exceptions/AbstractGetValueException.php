<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Exceptions;

use Exception;
use Throwable;

abstract class AbstractGetValueException extends Exception
{
    public function __construct(
        private readonly string $key,
        string $message,
        int $code = 400,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function getKey(): string
    {
        return $this->key;
    }
}

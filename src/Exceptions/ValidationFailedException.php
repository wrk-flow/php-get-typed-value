<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Exceptions;

use Throwable;

class ValidationFailedException extends AbstractGetValueException
{
    public function __construct(string $key, string $message, int $code = 400, ?Throwable $previous = null)
    {
        parent::__construct(sprintf('Validation failed for <%s> key. Reason: ', $key) . $message, $code, $previous);
    }
}

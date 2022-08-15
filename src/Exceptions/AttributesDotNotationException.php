<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Exceptions;

use Throwable;

class AttributesDotNotationException extends AbstractGetValueException
{
    public function __construct(string $key, int $code = 400, ?Throwable $previous = null)
    {
        parent::__construct($key, 'Attributes does not support dot notation - nesting not available', $code, $previous);
    }
}

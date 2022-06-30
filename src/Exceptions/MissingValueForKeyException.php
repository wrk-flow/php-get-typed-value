<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Exceptions;

class MissingValueForKeyException extends AbstractGetValueException
{
    public function __construct(string $key)
    {
        parent::__construct($key, sprintf('Data is missing a value for a key <%s>', $key));
    }
}

<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Exceptions;

class NotAnArrayException extends AbstractGetValueException
{
    public function __construct(string $key)
    {
        parent::__construct(sprintf('Given value is not array for key <%s>', $key));
    }
}

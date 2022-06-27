<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Exceptions;

class ArrayIsEmptyException extends AbstractGetValueException
{
    public function __construct(string $key)
    {
        parent::__construct(sprintf('Data has an empty array for a key <%s>', $key));
    }
}

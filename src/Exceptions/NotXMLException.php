<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Exceptions;

class NotXMLException extends AbstractGetValueException
{
    public function __construct(string $key)
    {
        parent::__construct($key, sprintf('Given value is not a XML <%s>', $key));
    }
}

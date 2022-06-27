<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\DataHolders;

abstract class AbstractData
{
    abstract public function getValue(string $key): mixed;

    abstract public function get(): mixed;
}

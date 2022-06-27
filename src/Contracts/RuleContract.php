<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Contracts;

interface RuleContract
{
    public function passes(mixed $value): bool;
}

<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Transformers;

use Wrkflow\GetValue\Contracts\RuleContract;

class RuleWasCalledRule implements RuleContract
{
    public bool $wasCalled = false;

    public mixed $wasCalledWithValue = null;

    public function passes(mixed $value): bool
    {
        $this->wasCalled = true;
        $this->wasCalledWithValue = $value;

        return true;
    }
}

<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Strategies;

use Wrkflow\GetValue\Contracts\TransformerStrategy;

class NoTransformerStrategy implements TransformerStrategy
{
    public function string(): array
    {
        return [];
    }

    public function int(): array
    {
        return [];
    }

    public function bool(): array
    {
        return [];
    }

    public function dateTime(): array
    {
        return [];
    }

    public function float(): array
    {
        return [];
    }

    public function array(): array
    {
        return [];
    }
}

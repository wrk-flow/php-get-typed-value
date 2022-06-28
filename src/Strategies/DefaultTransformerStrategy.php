<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Strategies;

use Wrkflow\GetValue\Contracts\TransformerStrategy;
use Wrkflow\GetValue\Transformers\TransformToBool;
use Wrkflow\GetValue\Transformers\TrimAndEmptyStringToNull;

class DefaultTransformerStrategy implements TransformerStrategy
{
    public function string(): array
    {
        return [new TrimAndEmptyStringToNull()];
    }

    public function int(): array
    {
        return [];
    }

    public function bool(): array
    {
        return [new TransformToBool()];
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

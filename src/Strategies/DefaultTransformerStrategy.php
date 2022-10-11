<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Strategies;

use Wrkflow\GetValue\Contracts\TransformerStrategyContract;
use Wrkflow\GetValue\Transformers\ReplaceCommaWithDot;
use Wrkflow\GetValue\Transformers\TransformToBool;
use Wrkflow\GetValue\Transformers\TrimAndEmptyStringToNull;

class DefaultTransformerStrategy implements TransformerStrategyContract
{
    public function string(): array
    {
        return [new TrimAndEmptyStringToNull()];
    }

    public function int(): array
    {
        return [new TrimAndEmptyStringToNull()];
    }

    public function bool(): array
    {
        return [new TransformToBool()];
    }

    public function dateTime(): array
    {
        return [new TrimAndEmptyStringToNull()];
    }

    public function float(): array
    {
        return [new TrimAndEmptyStringToNull(), new ReplaceCommaWithDot()];
    }

    public function array(): array
    {
        return [new TrimAndEmptyStringToNull()];
    }

    public function xml(): array
    {
        return [new TrimAndEmptyStringToNull()];
    }
}

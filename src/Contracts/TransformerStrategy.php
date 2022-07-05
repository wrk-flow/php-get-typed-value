<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Contracts;

interface TransformerStrategy
{
    /**
     * @return array<TransformerContract>
     */
    public function string(): array;

    /**
     * @return array<TransformerContract>
     */
    public function int(): array;

    /**
     * @return array<TransformerContract>
     */
    public function bool(): array;

    /**
     * @return array<TransformerContract>
     */
    public function dateTime(): array;

    /**
     * @return array<TransformerContract>
     */
    public function float(): array;

    /**
     * @return array<TransformerContract>
     */
    public function array(): array;
}

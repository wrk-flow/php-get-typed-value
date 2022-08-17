<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Entities;

class TestEntity
{
    public function __construct(
        public readonly string $type,
    ) {
    }
}

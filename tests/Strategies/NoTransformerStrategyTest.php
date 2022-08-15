<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Strategies;

use PHPUnit\Framework\TestCase;
use Wrkflow\GetValue\Strategies\NoTransformerStrategy;

class NoTransformerStrategyTest extends TestCase
{
    public function testNoStrategyIsEmpty(): void
    {
        $strategy = new NoTransformerStrategy();
        $this->assertEquals([], $strategy->bool());
        $this->assertEquals([], $strategy->array());
        $this->assertEquals([], $strategy->dateTime());
        $this->assertEquals([], $strategy->float());
        $this->assertEquals([], $strategy->string());
        $this->assertEquals([], $strategy->int());
        $this->assertEquals([], $strategy->xml());
    }
}

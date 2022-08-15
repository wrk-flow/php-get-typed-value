<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Strategies;

use PHPUnit\Framework\TestCase;
use Wrkflow\GetValue\Strategies\DefaultTransformerStrategy;
use Wrkflow\GetValue\Transformers\TransformToBool;
use Wrkflow\GetValue\Transformers\TrimAndEmptyStringToNull;

class DefaultTransformerStrategyTest extends TestCase
{
    public function testNoStrategyIsEmpty(): void
    {
        $strategy = new DefaultTransformerStrategy();
        $this->assertEquals([new TransformToBool()], $strategy->bool());
        $this->assertEquals([], $strategy->array());
        $this->assertEquals([], $strategy->dateTime());
        $this->assertEquals([], $strategy->float());
        $this->assertEquals([new TrimAndEmptyStringToNull()], $strategy->string());
        $this->assertEquals([], $strategy->int());
        $this->assertEquals([], $strategy->xml());
    }
}

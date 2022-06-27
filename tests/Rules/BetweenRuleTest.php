<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Rules;

use PHPUnit\Framework\TestCase;
use Wrkflow\GetValue\Rules\BetweenRule;

/**
 * Code originally taken from https://github.com/laurynasgadl/php-validator
 */
class BetweenRuleTest extends TestCase
{
    public function dataProvider(): array
    {
        return [
            ['12345678901', false],
            [11, false],
            [[1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 1], false],
            [11.0, false],
            [5.1, true],
            ['12345', true],
            [null, false],
            [true, false],
            [false, false],
            [1, false],
            [[1], false],
            [-10, false],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testPassesOnExisting(bool|float|int|string|null|array $arg, bool $expected): void
    {
        $this->assertEquals($expected, (new BetweenRule(5, 10))->passes($arg));
    }
}

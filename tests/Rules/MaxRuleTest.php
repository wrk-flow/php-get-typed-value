<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Rules;

use PHPUnit\Framework\TestCase;
use Wrkflow\GetValue\Rules\MaxRule;

/**
 * Code originally taken from https://github.com/laurynasgadl/php-validator
 */
class MaxRuleTest extends TestCase
{
    public function dataProvider(): array
    {
        return [
            ['1234567890', false],
            [10, false],
            [[1, 2, 3, 4, 5, 6, 7, 8, 9, 0], false],
            [10.0, false],
            [1.1, true],
            ['123', true],
            [null, true],
            [true, true],
            [false, true],
            [1, true],
            [[1], true],
            [-10, true],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testPassesOnExisting(string|int|array|float|null|bool $arg, bool $expected): void
    {
        $this->assertEquals($expected, (new MaxRule(5))->passes($arg));
    }
}

<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Rules;

use PHPUnit\Framework\TestCase;
use Wrkflow\GetValue\Rules\SizeRule;

/**
 * Code originally taken from https://github.com/laurynasgadl/php-validator
 */
class SizeRuleTest extends TestCase
{
    public function dataProvider(): array
    {
        return [
            ['1234567890', true],
            [10, true],
            [[1, 2, 3, 4, 5, 6, 7, 8, 9, 0], true],
            [10.0, true],
            [1.1, false],
            ['123', false],
            [null, false],
            [true, false],
            [false, false],
            [1, false],
            [[1], false],
            [[1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 1, 2, 3, 4, 5], false],
            [15, false],
            ['123456789012345', false],
            [15.5, false],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testPassesOnExisting(string|int|array|float|null|bool $arg, bool $expected): void
    {
        $this->assertEquals($expected, (new SizeRule(10))->passes($arg), 'With size ' . print_r($arg, true));
    }

    public function testPassesOnNull(): void
    {
        $this->assertEquals(true, (new SizeRule(0))->passes(null));
        $this->assertEquals(false, (new SizeRule(1))->passes(null));
    }
}

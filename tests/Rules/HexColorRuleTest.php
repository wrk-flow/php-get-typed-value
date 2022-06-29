<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Rules;

use PHPUnit\Framework\TestCase;
use Wrkflow\GetValue\Rules\HexColorRule;

class HexColorRuleTest extends TestCase
{
    public function dataProvider(): array
    {
        return [
            [0.0, false],
            [1.0, false],
            [false, false],
            [true, false],
            [1, false],
            [4544, false],
            ['12', false],
            ['#1', false],
            ['#FF', false],
            ['test', false],
            [[], false],
            ['red', false],
            ['yellow', false],
            ['#000', true],
            ['#0000', true],
            ['#00000', true],
            ['#00000', true],
            ['000', true],
            ['0000', true],
            ['00000', true],
            ['00000', true],
            ['#354D73', true],
            ['#063971', true],
            ['#F39F18', true],
            ['#FFF', true],
            ['#D84B20', true],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testPassesOnExisting(string|int|array|float|null|bool $arg, bool $expected): void
    {
        $this->assertEquals($expected, (new HexColorRule())->passes($arg));
    }
}

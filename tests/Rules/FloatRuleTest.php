<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Rules;

use PHPUnit\Framework\TestCase;
use Wrkflow\GetValue\Rules\FloatRule;

/**
 * Code originally taken from https://github.com/laurynasgadl/php-validator
 */
class FloatRuleTest extends TestCase
{
    public function dataProvider(): array
    {
        return [
            [0.0, true],
            [1.0, true],
            [false, false],
            [true, false],
            [1, false],
            ['123', false],
            [null, false],
            [[], false],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testPassesOnExisting(string|int|array|float|null|bool $arg, bool $expected): void
    {
        $this->assertEquals($expected, (new FloatRule())->passes($arg));
    }
}

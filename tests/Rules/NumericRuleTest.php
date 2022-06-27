<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Rules;

use PHPUnit\Framework\TestCase;
use Wrkflow\GetValue\Rules\NumericRule;

/**
 * Code originally taken from https://github.com/laurynasgadl/php-validator
 */
class NumericRuleTest extends TestCase
{
    public function dataProvider(): array
    {
        return [
            [0, true],
            [1, true],
            [false, false],
            [true, false],
            [1.1, true],
            ['123', true],
            ['abcd', false],
            [null, false],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testPassesOnExisting(string|int|null|float|bool $arg, bool $expected): void
    {
        $this->assertEquals($expected, (new NumericRule())->passes($arg));
    }
}

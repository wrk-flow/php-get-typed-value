<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Rules;

use PHPUnit\Framework\TestCase;
use Wrkflow\GetValue\Rules\BooleanRule;

/**
 * Code originally taken from https://github.com/laurynasgadl/php-validator
 */
class BooleanRuleTest extends TestCase
{
    public function dataProvider(): array
    {
        return [
            [0.0, false],
            [1.0, false],
            [false, true],
            [true, true],
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
        $this->assertEquals($expected, (new BooleanRule())->passes($arg));
    }
}

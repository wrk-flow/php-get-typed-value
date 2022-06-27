<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Rules;

use PHPUnit\Framework\TestCase;
use Wrkflow\GetValue\Rules\EmailRule;

/**
 * Code originally taken from https://github.com/laurynasgadl/php-validator
 */
class EmailRuleTest extends TestCase
{
    public function dataProvider(): array
    {
        return [
            [0.0, false],
            [1.0, false],
            [false, false],
            [true, false],
            [1, false],
            ['123', false],
            [null, false],
            [[], false],
            ['test@', false],
            ['@test', false],
            ['@test.com', false],
            ['test@test.com', true],
            ['test.test@test.com', true],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testPassesOnExisting(string|int|array|float|null|bool $arg, bool $expected): void
    {
        $this->assertEquals($expected, (new EmailRule())->passes($arg));
    }
}

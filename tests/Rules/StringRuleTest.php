<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Rules;

use PHPUnit\Framework\TestCase;
use Wrkflow\GetValue\Rules\StringRule;

/**
 * Code originally taken from https://github.com/laurynasgadl/php-validator
 */
class StringRuleTest extends TestCase
{
    public function dataProvider(): array
    {
        return [['test', true], [null, false], ['123', true], [[], false], [1.1, true], [123, true], [0, true]];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testPassesOnExisting(string|bool|null|int|float|array $arg, bool $expected): void
    {
        $this->assertEquals($expected, (new StringRule())->passes($arg));
    }
}

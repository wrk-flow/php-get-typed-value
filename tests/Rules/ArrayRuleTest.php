<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Rules;

use PHPUnit\Framework\TestCase;
use Wrkflow\GetValue\Rules\ArrayRule;

/**
 * Code originally taken from https://github.com/laurynasgadl/php-validator
 */
class ArrayRuleTest extends TestCase
{
    public function dataProvider(): array
    {
        return [[[], true], [null, false], [[1, 2, 3], true], ['test', false], [1.1, false], [123, false]];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testPassesOnExisting(array|bool|float|int|string|null $arg, bool $expected): void
    {
        $this->assertEquals($expected, (new ArrayRule())->passes($arg));
    }
}

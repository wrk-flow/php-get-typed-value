<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Rules;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Wrkflow\GetValue\Rules\IntegerRule;

/**
 * Code originally taken from https://github.com/laurynasgadl/php-validator
 */
class IntegerRuleTest extends TestCase
{
    /**
     * @return array<array-key, array<int, mixed>>
     */
    public static function dataProvider(): array
    {
        return [[0, true], [1, true], [false, false], [true, false], [1.1, false], ['123', false], [null, false]];
    }

    /**
     * @param array<array-key, mixed>|bool|float|int|string|null $arg
     */
    #[DataProvider('dataProvider')]
    public function testPassesOnExisting(string|int|array|float|null|bool $arg, bool $expected): void
    {
        $this->assertEquals($expected, (new IntegerRule())->passes($arg));
    }
}

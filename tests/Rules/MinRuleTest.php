<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Rules;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Wrkflow\GetValue\Rules\MinRule;

/**
 * Code originally taken from https://github.com/laurynasgadl/php-validator
 */
class MinRuleTest extends TestCase
{
    /**
     * @return array<array-key, array<int, mixed>>
     */
    public static function dataProvider(): array
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
        ];
    }

    /**
     * @param array<array-key, mixed>|bool|float|int|string|null $arg
     */
    #[DataProvider('dataProvider')]
    public function testPassesOnExisting(string|int|array|float|null|bool $arg, bool $expected): void
    {
        $this->assertEquals($expected, (new MinRule(5))->passes($arg));
    }
}

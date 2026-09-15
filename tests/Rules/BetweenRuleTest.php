<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Rules;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Wrkflow\GetValue\Rules\BetweenRule;

/**
 * Code originally taken from https://github.com/laurynasgadl/php-validator
 */
class BetweenRuleTest extends TestCase
{
    /**
     * @return array<array-key, array<int, mixed>>
     */
    public static function dataProvider(): array
    {
        return [
            ['12345678901', false],
            [11, false],
            [[1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 1], false],
            [11.0, false],
            [5.1, true],
            ['12345', true],
            [null, false],
            [true, false],
            [false, false],
            [1, false],
            [[1], false],
            [-10, false],
        ];
    }

    /**
     * @param array<array-key, mixed>|bool|float|int|string|null $arg
     */
    #[DataProvider('dataProvider')]
    public function testPassesOnExisting(bool|float|int|string|null|array $arg, bool $expected): void
    {
        $this->assertEquals($expected, (new BetweenRule(5, 10))->passes($arg));
    }
}

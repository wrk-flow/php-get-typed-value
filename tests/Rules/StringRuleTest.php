<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Rules;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Wrkflow\GetValue\Rules\StringRule;

/**
 * Code originally taken from https://github.com/laurynasgadl/php-validator
 */
class StringRuleTest extends TestCase
{
    /**
     * @return array<array-key, array<int, mixed>>
     */
    public static function dataProvider(): array
    {
        return [['test', true], [null, false], ['123', true], [[], false], [1.1, true], [123, true], [0, true]];
    }

    /**
     * @param array<array-key, mixed>|bool|float|int|string|null $arg
     */
    #[DataProvider('dataProvider')]
    public function testPassesOnExisting(string|bool|null|int|float|array $arg, bool $expected): void
    {
        $this->assertEquals($expected, (new StringRule())->passes($arg));
    }
}

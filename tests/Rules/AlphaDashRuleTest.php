<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Rules;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Wrkflow\GetValue\Rules\AlphaDashRule;

/**
 * Code originally taken from https://github.com/laurynasgadl/php-validator
 */
class AlphaDashRuleTest extends TestCase
{
    /**
     * @return array<array-key, array<int, mixed>>
     */
    public static function dataProvider(): array
    {
        return [
            ['Test', true],
            ['123', true],
            ['test123_', true],
            ['_', true],
            [123, true],
            [null, false],
            ['!test', false],
            [1.1, false],
            ['?!123', false],
        ];
    }

    #[DataProvider('dataProvider')]
    public function testPassesOnExisting(string|int|null|float $arg, bool $expected): void
    {
        $this->assertEquals($expected, (new AlphaDashRule())->passes($arg));
    }
}

<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Rules;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Wrkflow\GetValue\Rules\AlphaNumericRule;

/**
 * Code originally taken from https://github.com/laurynasgadl/php-validator
 */
class AlphaNumericRuleTest extends TestCase
{
    /**
     * @return array<array-key, array<int, mixed>>
     */
    public static function dataProvider(): array
    {
        return [
            ['Test', true],
            ['123', true],
            [123, true],
            [null, false],
            ['!test', false],
            [1.1, false],
            ['?!123', false],
            ['test123_', false],
            ['test123-', false],
            ['_', false],
        ];
    }

    #[DataProvider('dataProvider')]
    public function testPassesOnExisting(bool|float|int|string|null $arg, bool $expected): void
    {
        $this->assertEquals($expected, (new AlphaNumericRule())->passes($arg));
    }
}

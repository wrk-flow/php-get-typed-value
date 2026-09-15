<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Rules;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Wrkflow\GetValue\Rules\IpRule;

/**
 * Code originally taken from https://github.com/laurynasgadl/php-validator
 */
class IpRuleTest extends TestCase
{
    /**
     * @return array<array-key, array<int, mixed>>
     */
    public static function dataProvider(): array
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
            ['test', false],
            ['www.test', false],
            ['123.123', false],
            ['1.1.1.1', true],
            ['127.0.0.1', true],
            ['2001:0db8:85a3:0000:0000:8a2e:0370:7334', true],
        ];
    }

    /**
     * @param array<array-key, mixed>|bool|float|int|string|null $arg
     */
    #[DataProvider('dataProvider')]
    public function testPassesOnExisting(string|int|array|float|null|bool $arg, bool $expected): void
    {
        $this->assertEquals($expected, (new IpRule())->passes($arg));
    }
}

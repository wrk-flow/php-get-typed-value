<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Rules;

use PHPUnit\Framework\TestCase;
use Wrkflow\GetValue\Rules\UrlRule;

/**
 * Code originally taken from https://github.com/laurynasgadl/php-validator
 */
class UrlRuleTest extends TestCase
{
    /**
     * @return array<int, array<string|bool|null|int|float|array>>
     */
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
            ['test', false],
            ['www.test', false],
            ['test.com', false],
            ['http://test', true],
            ['http://test.com', true],
            ['https://www.test.com/api/test?test=true', true],
            ['https://www.test.com api/test?test=true', false],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testPassesOnExisting(string|bool|null|int|float|array $arg, bool $expected): void
    {
        $this->assertEquals($expected, (new UrlRule())->passes($arg));
    }
}

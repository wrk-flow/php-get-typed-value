<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Rules;

use PHPUnit\Framework\TestCase;
use Wrkflow\GetValue\Rules\RegexRule;

/**
 * Code originally taken from https://github.com/laurynasgadl/php-validator
 */
class RegexRuleTest extends TestCase
{
    public function dataProvider(): array
    {
        return [
            ['/^[A-Za-z]+$/', 'Test', true],
            ['/^\d+$/', '123', true],
            ['/^[0-9A-Za-z\-_]+$/', 'test123_', true],
            ['/^_$/', '_', true],
            ['/^\d+$/', 123, true],
            ['/^\d+$/', null, false],
            ['/^[a-z]+$/', '!test', false],
            ['/^\d+$/', 1.1, false],
            ['/^[\-_]+$/', '?!123', false],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testPassesOnExisting(string $pattern, string|null|int|float $arg, bool $expected): void
    {
        $this->assertEquals($expected, (new RegexRule($pattern))->passes($arg));
    }
}

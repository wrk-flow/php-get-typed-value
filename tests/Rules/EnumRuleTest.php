<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Rules;

use LogicException;
use PHPUnit\Framework\TestCase;
use Wrkflow\GetValue\Rules\EnumRule;
use Wrkflow\GetValueTests\Enums\EnumInt;
use Wrkflow\GetValueTests\Enums\EnumOther;
use Wrkflow\GetValueTests\Enums\EnumString;

class EnumRuleTest extends TestCase
{
    public function dataString(): array
    {
        return [['test', true], ['test-2', true], ['test-4', false], [3, false], ['', false], [[], false]];
    }

    /**
     * @dataProvider dataString
     */
    public function testString(string|int|array|float|null|bool $arg, bool $expected): void
    {
        $this->assertEquals($expected, (new EnumRule(EnumString::class))->passes($arg));
    }

    public function dataInt(): array
    {
        return [[1, true], ['1', true], [3, false], ['3', false], ['', false], [[], false]];
    }

    /**
     * @dataProvider dataInt
     */
    public function testInt(string|int|array|float|null|bool $arg, bool $expected): void
    {
        $this->assertEquals($expected, (new EnumRule(EnumInt::class))->passes($arg));
    }

    public function testNotEnum(): void
    {
        $this->expectExceptionMessage('Provided enum <' . self::class . '> is not an enum or it does not exists.');

        $this->expectException(LogicException::class);

        // @phpstan-ignore-next-line
        (new EnumRule(self::class))->passes('test');
    }

    public function testEnumWithoutValues(): void
    {
        $this->expectExceptionMessage(
            'Provided enum <' . EnumOther::class . '> is not supported. Use string/int enum.'
        );
        $this->expectException(LogicException::class);

        // @phpstan-ignore-next-line
        (new EnumRule(EnumOther::class))->passes('test');
    }
}

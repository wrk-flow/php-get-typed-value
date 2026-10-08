<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Wrkflow\GetValue\Contracts\TransformerContract;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\Exceptions\NotSupportedDataException;
use Wrkflow\GetValue\Exceptions\ValidationFailedException;
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\Transformers\ArrayItemTransformer;

class GetValueStringKeyArrayTest extends TestCase
{
    public function testPreservesKeysAndValues(): void
    {
        $expected = [
            'name' => 'example',
            'nested' => [1, null],
            'enabled' => false,
            '01' => 3,
        ];
        $data = new GetValue(new ArrayData([
            'custom_data' => $expected,
        ]));

        self::assertSame($expected, $data->getStringKeyArray('custom_data'));
        self::assertSame($expected, $data->getStringKeyArray(['custom_data']));
    }

    public function testMissingNullAndEmptyArrays(): void
    {
        $data = new GetValue(new ArrayData([
            'null' => null,
            'empty' => [],
        ]));

        self::assertSame([], $data->getStringKeyArray('missing'));
        self::assertSame([], $data->getStringKeyArray('null'));
        self::assertSame([], $data->getStringKeyArray('empty'));
    }

    public function testRootArray(): void
    {
        $expected = [
            'name' => 'example',
        ];
        $data = new GetValue(new ArrayData($expected));

        self::assertSame($expected, $data->getStringKeyArray([]));
    }

    /**
     * @return array<string, array{array<array-key, mixed>}>
     */
    public static function invalidKeys(): array
    {
        return [
            'list' => [['example']],
            'mixed keys' => [[
                'name' => 'example',
                2 => 'invalid',
            ]],
            'numeric string key' => [[
                '123' => 'invalid',
            ]],
        ];
    }

    /**
     * @param array<array-key, mixed> $value
     */
    #[DataProvider('invalidKeys')]
    public function testRejectsIntegerKeys(array $value): void
    {
        $data = new GetValue(new ArrayData([
            'custom_data' => $value,
        ], 'payload'));

        $this->expectException(ValidationFailedException::class);
        $this->expectExceptionMessage('payload.custom_data');
        $data->getStringKeyArray('custom_data');
    }

    public function testRejectsNonArray(): void
    {
        $data = new GetValue(new ArrayData([
            'custom_data' => 'invalid',
        ]));

        $this->expectException(NotSupportedDataException::class);
        $data->getStringKeyArray('custom_data');
    }

    public function testRejectsIntegerKeysIntroducedByTransformer(): void
    {
        $data = new GetValue(new ArrayData([
            'custom_data' => [
                'name' => 'example',
            ],
        ]));
        $transformer = new class() implements TransformerContract {
            public function beforeValidation(mixed $value, string $key): bool
            {
                return false;
            }

            public function transform(mixed $value, string $key, GetValue $getValue): mixed
            {
                return ['invalid'];
            }
        };

        $this->expectException(ValidationFailedException::class);
        $data->getStringKeyArray('custom_data', [$transformer]);
    }

    public function testValidatesTransformedResult(): void
    {
        $data = new GetValue(new ArrayData([
            'custom_data' => [
                'count' => '2',
            ],
        ]));
        $transformer = new ArrayItemTransformer(static fn (mixed $value, string $key): int => 2);

        self::assertSame([
            'count' => 2,
        ], $data->getStringKeyArray('custom_data', [$transformer]));
    }
}

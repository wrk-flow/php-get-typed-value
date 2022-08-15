<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\DataHolders;

use PHPUnit\Framework\TestCase;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\Enums\ValueType;

class ArrayDataTest extends TestCase
{
    private ArrayData $data;

    private array $array;

    protected function setUp(): void
    {
        parent::setUp();

        $this->array = [
            'string' => 'Marco',
            'null' => null,
            'array' => [
                'child' => 'Peace',
                'array' => ['Polo'],
            ],
            'domains' => [
                'co.uk' => 'peace.co.uk with array',
                'com' => 'peace.com',
                'co' => [
                    'uk' => 'peace.co.uk',
                ],
                'com.uk' => 'works',
            ],
            'dot.' => 'key',
        ];
        $this->data = new ArrayData($this->array);
    }

    public function testGet(): void
    {
        $this->assertSame($this->array, $this->data->get());
    }

    public function testGetValueUsingDotNotation(): void
    {
        $this->assertSame(['Polo'], $this->data->getValue('array.array', ValueType::String));
        $this->assertSame('Polo', $this->data->getValue('array.array.0', ValueType::String));
        $this->assertSame('Peace', $this->data->getValue('array.child', ValueType::String));
        $this->assertNull($this->data->getValue('array.array.0.0', ValueType::String));
        $this->assertNull($this->data->getValue('array.10', ValueType::String));
        $this->assertNull($this->data->getValue('array.com.uk', ValueType::String));
        $this->assertSame('peace.co.uk', $this->data->getValue('domains.co.uk', ValueType::String));
    }

    public function testDotNotationWithDotForcingAnArrayAtAllCases(): void
    {
        $this->assertNull($this->data->getValue('dot.', ValueType::String));
        $this->assertSame('key', $this->data->getValue(['dot.'], ValueType::String));
    }

    public function testGetValueUsingArray(): void
    {
        $this->assertSame('peace.co.uk', $this->data->getValue(['domains', 'co', 'uk'], ValueType::String));
        $this->assertSame('peace.co.uk with array', $this->data->getValue(['domains', 'co.uk'], ValueType::String));
        $this->assertSame('works', $this->data->getValue(['domains', 'com.uk'], ValueType::String));
    }

    public function testNull(): void
    {
        $this->assertNull($this->data->getValue('null', ValueType::String));
    }

    public function testWithoutDotNotation(): void
    {
        $this->assertSame('Marco', $this->data->getValue('string', ValueType::String));
        $this->assertSame($this->data->get()['array'], $this->data->getValue('array', ValueType::String));
    }
}

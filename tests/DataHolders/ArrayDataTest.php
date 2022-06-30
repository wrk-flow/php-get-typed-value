<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\DataHolders;

use PHPUnit\Framework\TestCase;
use Wrkflow\GetValue\DataHolders\ArrayData;

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
        $this->assertSame(['Polo'], $this->data->getValue('array.array'));
        $this->assertSame('Polo', $this->data->getValue('array.array.0'));
        $this->assertSame('Peace', $this->data->getValue('array.child'));
        $this->assertNull($this->data->getValue('array.array.0.0'));
        $this->assertNull($this->data->getValue('array.10'));
        $this->assertNull($this->data->getValue('array.com.uk'));
        $this->assertSame('peace.co.uk', $this->data->getValue('domains.co.uk'));
    }

    public function testDotNotationWithDotForcingAnArrayAtAllCases(): void
    {
        $this->assertNull($this->data->getValue('dot.'));
        $this->assertSame('key', $this->data->getValue(['dot.']));
    }

    public function testGetValueUsingArray(): void
    {
        $this->assertSame('peace.co.uk', $this->data->getValue(['domains', 'co', 'uk']));
        $this->assertSame('peace.co.uk with array', $this->data->getValue(['domains', 'co.uk']));
        $this->assertSame('works', $this->data->getValue(['domains', 'com.uk']));
    }

    public function testNull(): void
    {
        $this->assertNull($this->data->getValue('null'));
    }

    public function testWithoutDotNotation(): void
    {
        $this->assertSame('Marco', $this->data->getValue('string'));
        $this->assertSame($this->data->get()['array'], $this->data->getValue('array'));
    }
}

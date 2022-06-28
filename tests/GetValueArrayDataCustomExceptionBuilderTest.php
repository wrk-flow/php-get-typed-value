<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests;

use PHPUnit\Framework\TestCase;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\Rules\EmailRule;
use Wrkflow\GetValueTests\Builders\CustomExceptionBuilder;

class GetValueArrayDataCustomExceptionBuilderTest extends TestCase
{
    private GetValue $data;

    protected function setUp(): void
    {
        parent::setUp();

        $this->data = new GetValue(
            data: new ArrayData([
                'test' => 'Ok',
                'array' => ['test'],
                'empty' => [],
            ]),
            exceptionBuilder: new CustomExceptionBuilder()
        );
    }

    public function testExistingString(): void
    {
        $this->assertEquals('Ok', $this->data->getRequiredString('test'));
    }

    public function testExistingArray(): void
    {
        $this->assertEquals(['test'], $this->data->getRequiredArray('array'));
    }

    public function testMissingString(): void
    {
        $this->expectExceptionMessage('missingValue: miss');
        $this->data->getRequiredString('miss');
    }

    public function testMissingInt(): void
    {
        $this->expectExceptionMessage('missingValue: miss');
        $this->data->getRequiredInt('miss');
    }

    public function testMissingBool(): void
    {
        $this->expectExceptionMessage('missingValue: miss');
        $this->data->getRequiredBool('miss');
    }

    public function testMissingFloat(): void
    {
        $this->expectExceptionMessage('missingValue: miss');
        $this->data->getRequiredFloat('miss');
    }

    public function testMissingDateTime(): void
    {
        $this->expectExceptionMessage('missingValue: miss');
        $this->data->getRequiredDateTime('miss');
    }

    public function testEmptyArray(): void
    {
        $this->expectExceptionMessage('arrayIsEmpty: empty');
        $this->data->getRequiredArray('empty');
    }

    public function testNotArray(): void
    {
        $this->expectExceptionMessage('notAnArray: test');
        $this->data->getRequiredArray('test');
    }

    public function testRuleFailed(): void
    {
        $this->expectExceptionMessage('validationFailed: test Wrkflow\GetValue\Rules\EmailRule');
        $this->data->getString('test', [new EmailRule()]);
    }
}

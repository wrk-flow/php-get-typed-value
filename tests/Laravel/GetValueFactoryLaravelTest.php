<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Laravel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;
use Wrkflow\GetValue\GetValueFactory;
use Wrkflow\GetValueTests\Mocks\ValidatorMock;

class GetValueFactoryLaravelTest extends TestCase
{
    private GetValueFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->factory = new GetValueFactory();
    }

    public function testRequestAll(): void
    {
        $getValue = $this->factory->requestAll(new Request([
            'test' => 'This is a test',
            'not_validated' => 'Test',
        ]));

        $this->assertEquals('This is a test', $getValue->getRequiredString('test'));
        $this->assertEquals('Test', $getValue->getString('not_validated'));
    }

    public function testRequestValidated(): void
    {
        $getValue = $this->factory->request($this->getFormRequest());

        $this->assertEquals('This is a test', $getValue->getRequiredString('test'));
        $this->assertNull($getValue->getString('not_validated'));
    }

    public function testRequestAllWithFormRequest(): void
    {
        $request = $this->getFormRequest();
        $getValue = $this->factory->requestAll($request);

        $this->assertEquals('This is a test', $getValue->getRequiredString('test'));
        $this->assertEquals('Test', $getValue->getString('not_validated'));
    }

    protected function getFormRequest(): FormRequest
    {
        $request = new FormRequest([
            'test' => 'This is a test',
            'not_validated' => 'Test',
        ]);
        $validator = new ValidatorMock([
            'test' => 'This is a test',
        ]);
        FormRequest::macro('validate', fn () => $validator->validate());
        $request->setValidator($validator);
        $request->validate([
            'test' => 'string',
        ]);
        return $request;
    }
}

<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Laravel;

use Illuminate\Http\Request;

class GetValueFormRequestTest extends AbstractLaravelTestCase
{
    public function testNoValue(): void
    {
        $request = $this->app()
            ->make(TestFormRequest::class);
        assert($request instanceof TestFormRequest);
        $this->assertNull($request->getTest());
    }

    public function testHasValue(): void
    {
        $appRequest = $this->app()
            ->get('request');
        assert($appRequest instanceof Request);
        $appRequest->initialize(request: [
            'test' => 'Works',
        ]);
        $appRequest->setMethod('POST'); // Use request data

        $request = $this->app()
            ->make(TestFormRequest::class);
        assert($request instanceof TestFormRequest);

        $this->assertEquals('Works', $request->getTest());
    }
}

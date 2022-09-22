<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Laravel;

use Illuminate\Http\Request;

class GetValueFormRequestTest extends AbstractLaravelTestCase
{
    public function testNoValue(): void
    {
        /** @var TestFormRequest $request */
        $request = $this->app->make(TestFormRequest::class);
        $this->assertNull($request->getTest());
    }

    public function testHasValue(): void
    {
        /** @var Request $appRequest */
        $appRequest = $this->app['request'];
        $appRequest->initialize(request: [
            'test' => 'Works',
        ]);
        $appRequest->setMethod('POST'); // Use request data

        $request = $this->app->make(TestFormRequest::class);
        $this->assertEquals('Works', $request->getTest());
    }
}

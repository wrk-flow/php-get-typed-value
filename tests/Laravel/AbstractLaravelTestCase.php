<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Laravel;

use Illuminate\Contracts\Foundation\Application;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class AbstractLaravelTestCase extends BaseTestCase
{
    public function app(): Application
    {
        assert($this->app instanceof Application);

        return $this->app;
    }
}

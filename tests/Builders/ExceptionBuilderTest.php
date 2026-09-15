<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Builders;

use PHPUnit\Framework\TestCase;
use Wrkflow\GetValue\Builders\ExceptionBuilder;
use Wrkflow\GetValue\Exceptions\AbstractGetValueException;

class ExceptionBuilderTest extends TestCase
{
    public function testExceptionGetKey(): void
    {
        $exception = (new ExceptionBuilder())
            ->missingValue('key');

        /** @var AbstractGetValueException $exception */
        $this->assertEquals('key', $exception->getKey());
    }
}

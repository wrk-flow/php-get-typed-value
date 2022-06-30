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

        $this->assertInstanceOf(AbstractGetValueException::class, $exception);

        if ($exception instanceof AbstractGetValueException) {
            $this->assertEquals('key', $exception->getKey());
        }
    }
}

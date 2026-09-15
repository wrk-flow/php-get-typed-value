<?php

declare(strict_types=1);

use LaraStrict\Conventions\ExtensionFiles;
use Rector\Config\RectorConfig;
use Rector\PHPUnit\PHPUnit60\Rector\ClassMethod\AddDoesNotPerformAssertionToNonAssertingTestRector;

return RectorConfig::configure()
    ->withSets([ExtensionFiles::Rector])
    ->withComposerBased(phpunit: true)
    ->withRootFiles()
    ->withPaths([__DIR__ . '/src', __DIR__ . '/tests'])
    ->withSkip([AddDoesNotPerformAssertionToNonAssertingTestRector::class]);

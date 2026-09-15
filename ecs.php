<?php

declare(strict_types=1);

use LaraStrict\Conventions\ExtensionFiles;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return ECSConfig::configure()
    ->withRootFiles()
    ->withPaths([__DIR__ . '/src', __DIR__ . '/tests'])
    ->withSets([ExtensionFiles::Ecs]);

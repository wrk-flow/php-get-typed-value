<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests;

use PHPUnit\Framework\TestCase;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\GetValue;

abstract class AbstractArrayTestCase extends TestCase
{
    final protected const KeyTags = 'tags';

    final protected const KeyName = 'name';

    final protected const KeyItems = 'items';

    final protected const KeyPage = 'page';

    final protected const KeyLabel = 'label';

    final protected const KeyValid = 'valid';

    final protected const KeyNull = 'null';

    final protected const KeyEmpty = 'empty';

    final protected const KeyMissingValue = 'missing_value';

    protected GetValue $data;

    protected function setUp(): void
    {
        parent::setUp();

        $this->data = new GetValue(new ArrayData([
            self::KeyPage => 1,
            self::KeyItems => [
                [
                    self::KeyName => 'test',
                    self::KeyTags => null,
                    self::KeyLabel => 'yes',
                ],
                [
                    self::KeyName => 'test 2',
                    self::KeyTags => ['test'],
                ],
            ],
            self::KeyNull => [
                self::KeyTags => null,
            ],
            self::KeyEmpty => [
                self::KeyTags => [],
            ],
            self::KeyValid => [
                self::KeyTags => ['test'],
            ],
            self::KeyMissingValue => ['force-non-empty'],
        ]));
    }
}

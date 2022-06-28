<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests;

use PHPUnit\Framework\TestCase;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\GetValue;

abstract class AbstractArrayTestCase extends TestCase
{
    final public const KeyEmail = 'email';

    final public const KeyInvalid = 'invalid';

    final public const KeyAmount = 'amount';

    final public const KeyUpdatedAt = 'updated_at';

    final public const KeyItemsEmpty = 'items_empty';

    final public const KeyPageString = 'page_string';

    final protected const KeyTags = 'tags';

    final protected const KeyItemName = 'name';

    final protected const KeyItems = 'items';

    final protected const KeyPage = 'page';

    final protected const KeyItemLabel = 'label';

    final protected const KeyValid = 'valid';

    final protected const KeyNull = 'null';

    final protected const KeyEmpty = 'empty';

    final protected const KeyMissingValue = 'missing_value';

    final protected const KeyIsActive = 'is_active';

    final protected const KeyIsActiveInFalse = 'is_active_false';

    protected GetValue $data;

    protected function setUp(): void
    {
        parent::setUp();

        $this->data = new GetValue(new ArrayData([
            self::KeyPage => 1,
            self::KeyPageString => '1',
            self::KeyEmail => 'martin@kluska.cz',
            self::KeyItemsEmpty => [],
            self::KeyItems => [
                [
                    self::KeyItemName => 'test',
                    self::KeyTags => null,
                    self::KeyItemLabel => 'yes',
                ],
                [
                    self::KeyItemName => 'test 2',
                    self::KeyTags => ['test'],
                ],
            ],
            self::KeyNull => [
                self::KeyTags => null,
                self::KeyEmail => null,
                self::KeyPage => null,
                self::KeyIsActive => null,
                self::KeyIsActiveInFalse => null,
                self::KeyAmount => null,
                self::KeyUpdatedAt => null,
            ],
            self::KeyEmpty => [
                self::KeyTags => [],
                self::KeyEmail => '',
                self::KeyPage => '',
                self::KeyIsActive => '',
                self::KeyIsActiveInFalse => '',
                self::KeyAmount => '',
                self::KeyUpdatedAt => '',
            ],
            self::KeyValid => [
                self::KeyTags => ['test'],
                self::KeyEmail => 'martin@kluska.cz',
                self::KeyPage => 10,
                self::KeyIsActive => true,
                self::KeyIsActiveInFalse => false,
                self::KeyAmount => 10.2,
                self::KeyUpdatedAt => '2022-02-02 23:22:21',
            ],
            self::KeyInvalid => [
                self::KeyTags => 'test',
                self::KeyEmail => [],
                self::KeyPage => 'not_int',
                self::KeyIsActive => 'not_bool',
                self::KeyIsActiveInFalse => 'not_bool',
                self::KeyAmount => 'not_float',
                self::KeyUpdatedAt => 'not_date_time',
            ],
            self::KeyMissingValue => ['force-non-empty'],
        ]));
    }
}
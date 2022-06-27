<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests;

use Wrkflow\GetValue\GetValue;

class GetValueArrayDataTest extends AbstractArrayTestCase
{
    public function testGetRequiredArrayGetter(): void
    {
        $this->assertEquals(1, $this->data->getRequiredInt(self::KeyPage));

        $items = $this->data->getRequiredArrayGetter(self::KeyItems);
        $this->assertCount(2, $items->data->get());

        $item = $items->getRequiredArrayGetter('0');

        $this->assertItem(item: $item, expectedName: 'test', expectedLabel: 'yes', expectedTags: []);

        $item = $items->getRequiredArrayGetter('1');

        $this->assertItem(item: $item, expectedName: 'test 2', expectedLabel: null, expectedTags: ['test']);
    }

    protected function assertItem(
        GetValue $item,
        string $expectedName,
        ?string $expectedLabel,
        array $expectedTags
    ): void {
        $name = $item->getRequiredString(self::KeyName);
        $this->assertEquals($expectedName, $name);

        $tags = $item->getArray(self::KeyTags);
        $this->assertEquals($expectedTags, $tags);

        $label = $item->getString(self::KeyLabel);
        $this->assertEquals($expectedLabel, $label);
    }
}

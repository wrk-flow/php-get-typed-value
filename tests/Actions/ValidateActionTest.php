<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Actions;

use Exception;
use PHPUnit\Framework\TestCase;
use stdClass;
use Wrkflow\GetValue\Actions\ValidateAction;
use Wrkflow\GetValueTests\Builders\CustomExceptionBuilder;
use Wrkflow\GetValueTests\Rules\TestRule;

class ValidateActionTest extends TestCase
{
    public function data(): array
    {
        return [
            ['', '(empty string)'],
            ['fail', 'fail'],
            [
                'very long string that will be cut off with. This can contain max 30 characters with the dots.',
                'very long string that will ...',
            ],
            [1, '1'],
            [null, '(null)'],
            [[], '(array with count 0)'],
            [[1, 2], '(array with count 2)'],
            [[
                'marco' => 1,
                'polo' => 2,
                3,
            ], '(array with count 3)'],
            [new stdClass(), ''],
        ];
    }

    /**
     * @dataProvider data
     */
    public function testConvertsValuesToHumanDescription(mixed $value, string $expectedValueMessage): void
    {
        $action = new ValidateAction(new CustomExceptionBuilder());
        try {
            $action->execute([new TestRule()], $value, 'test');
        } catch (Exception $exception) {
            $this->assertStringContainsString('value: <' . $expectedValueMessage . '>', $exception->getMessage());
        }
    }
}

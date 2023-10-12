<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Laravel;

use Closure;
use PHPUnit\Framework\Assert;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;
use Wrkflow\GetValue\GetValueFactory;
use Wrkflow\GetValue\Laravel\GetValueFactoryCommand;

class GetValueFactoryCommandTest extends AbstractLaravelTestCase
{
    /**
     * @return array<string|int, array{0: Closure(static):void}>
     */
    public function dataCommand(): array
    {
        return [
            'argument only' => [
                fn (self $self) => $self->assertCommand(
                    input: 'test',
                    expectedArgument: 'test',
                    expectedBoolOption: false,
                    expectedValueOption: null,
                ),
            ],
            'argument, option' => [
                fn (self $self) => $self->assertCommand(
                    input: 'test --option',
                    expectedArgument: 'test',
                    expectedBoolOption: true,
                    expectedValueOption: null,
                ),
            ],
            'argument, option, value' => [
                fn (self $self) => $self->assertCommand(
                    input: 'test --option --value=test22',
                    expectedArgument: 'test',
                    expectedBoolOption: true,
                    expectedValueOption: 'test22',
                ),
            ],
        ];
    }

    /**
     * @param Closure(static):void $assert
     *
     * @dataProvider dataCommand
     */
    public function testCommand(Closure $assert): void
    {
        $assert($this);
    }

    public function assertCommand(
        string $input,
        ?string $expectedArgument,
        bool $expectedBoolOption,
        ?string $expectedValueOption,
    ): void {
        $command = new class(
            new GetValueFactory(),
            $expectedArgument,
            $expectedBoolOption,
            $expectedValueOption,
        ) extends GetValueFactoryCommand {
            protected $signature = 'test {argument} {--option} {--value=}';

            public function __construct(
                private readonly GetValueFactory $getValueFactory,
                private readonly ?string $expectedArgument,
                private readonly ?bool $expectedBoolOption,
                private readonly ?string $expectedValueOption,
            ) {
                parent::__construct($this->getValueFactory);
            }

            public function handle(): void
            {
                Assert::assertSame($this->expectedArgument, $this->inputData->getString('argument'));
                Assert::assertSame($this->expectedBoolOption, $this->inputData->getBool('option'));
                Assert::assertSame($this->expectedValueOption, $this->inputData->getString('value'));
            }
        };

        $command->setLaravel($this->app());

        $command->run(new StringInput($input), new NullOutput());
    }
}

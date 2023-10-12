<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Laravel;

use Closure;
use Illuminate\Console\Command;
use PHPUnit\Framework\Assert;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;
use Wrkflow\GetValue\GetValueFactory;

class GetValueFactoryLaravelCommandTest extends AbstractLaravelTestCase
{
    private GetValueFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->factory = new GetValueFactory();
    }

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
            $this->factory,
            $expectedArgument,
            $expectedBoolOption,
            $expectedValueOption,
        ) extends Command {
            protected $signature = 'test {argument} {--option} {--value=}';

            public function __construct(
                private readonly GetValueFactory $getValueFactory,
                private readonly ?string $expectedArgument,
                private readonly ?bool $expectedBoolOption,
                private readonly ?string $expectedValueOption,
            ) {
                parent::__construct();
            }

            public function handle(): void
            {
                $data = $this->getValueFactory->command($this);

                Assert::assertSame($this->expectedArgument, $data->getString('argument'));
                Assert::assertSame($this->expectedBoolOption, $data->getBool('option'));
                Assert::assertSame($this->expectedValueOption, $data->getString('value'));
            }
        };

        $command->setLaravel($this->app());

        $command->run(new StringInput($input), new NullOutput());
    }
}

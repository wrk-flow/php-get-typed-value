<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Laravel;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\GetValueFactory;

class GetValueFactoryCommand extends Command
{
    protected GetValue $inputData;

    public function __construct(
        private readonly GetValueFactory $getValueFactory,
    ) {
        parent::__construct();
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        parent::initialize($input, $output);

        $this->inputData = $this->getValueFactory->command($this);
    }
}

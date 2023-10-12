<?php

declare(strict_types=1);

namespace Wrkflow\GetValue;

use Illuminate\Console\Command;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use SimpleXMLElement;
use Wrkflow\GetValue\Builders\ExceptionBuilder;
use Wrkflow\GetValue\Contracts\ExceptionBuilderContract;
use Wrkflow\GetValue\Contracts\TransformerStrategyContract;
use Wrkflow\GetValue\DataHolders\AbstractData;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\DataHolders\XMLData;
use Wrkflow\GetValue\Strategies\DefaultTransformerStrategy;

class GetValueFactory
{
    public function __construct(
        public readonly TransformerStrategyContract $transformerStrategy = new DefaultTransformerStrategy(),
        public readonly ExceptionBuilderContract $exceptionBuilder = new ExceptionBuilder(),
    ) {
    }

    /**
     * Wraps all request data.
     */
    public function requestAll(Request $request, string $parentKey = ''): GetValue
    {
        return $this->array($request->all(), $parentKey);
    }

    /**
     * Wraps validated request data.
     */
    public function request(FormRequest $request, string $parentKey = ''): GetValue
    {
        return $this->array($request->validated(), $parentKey);
    }

    public function xml(SimpleXMLElement $xml, string $parentKey = ''): GetValue
    {
        return $this->make(new XMLData($xml, $parentKey));
    }

    public function array(array $array, string $parentKey = ''): GetValue
    {
        return $this->make(new ArrayData($array, $parentKey));
    }

    /**
     * Wraps and merges command arguments and options.
     */
    public function command(Command $command): GetValue
    {
        return $this->array(array_merge($command->arguments(), $command->options()));
    }

    protected function make(AbstractData $data): GetValue
    {
        return new GetValue(
            data: $data,
            transformerStrategy: $this->transformerStrategy,
            exceptionBuilder: $this->exceptionBuilder,
        );
    }
}

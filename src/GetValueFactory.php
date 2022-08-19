<?php

declare(strict_types=1);

namespace Wrkflow\GetValue;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use SimpleXMLElement;
use Wrkflow\GetValue\Builders\ExceptionBuilder;
use Wrkflow\GetValue\Contracts\ExceptionBuilderContract;
use Wrkflow\GetValue\Contracts\TransformerStrategy;
use Wrkflow\GetValue\DataHolders\AbstractData;
use Wrkflow\GetValue\DataHolders\ArrayData;
use Wrkflow\GetValue\DataHolders\XMLData;
use Wrkflow\GetValue\Strategies\DefaultTransformerStrategy;

class GetValueFactory
{
    public function __construct(
        public readonly TransformerStrategy $transformerStrategy = new DefaultTransformerStrategy(),
        public readonly ExceptionBuilderContract $exceptionBuilder = new ExceptionBuilder(),
    ) {
    }

    public function requestAll(Request $request, string $parentKey = ''): GetValue
    {
        return $this->array($request->all(), $parentKey);
    }

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

    protected function make(AbstractData $data): GetValue
    {
        return new GetValue(
            data: $data,
            transformerStrategy: $this->transformerStrategy,
            exceptionBuilder: $this->exceptionBuilder,
        );
    }
}

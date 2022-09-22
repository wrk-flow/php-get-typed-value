<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Laravel;

use Illuminate\Foundation\Http\FormRequest;
use Wrkflow\GetValue\GetValue;
use Wrkflow\GetValue\GetValueFactory;

class GetValueFormRequest extends FormRequest
{
    protected GetValue $data;

    protected function passedValidation()
    {
        parent::passedValidation();

        /** @var GetValueFactory $getValueFactory */
        $getValueFactory = $this->container->make(GetValueFactory::class);

        $this->data = $getValueFactory->request($this);
    }
}

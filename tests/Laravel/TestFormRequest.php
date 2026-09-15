<?php

declare(strict_types=1);

namespace Wrkflow\GetValueTests\Laravel;

use Wrkflow\GetValue\Laravel\GetValueFormRequest;

class TestFormRequest extends GetValueFormRequest
{
    final public const string KeyTest = 'test';

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            self::KeyTest => ['sometimes', 'string'],
        ];
    }

    public function getTest(): ?string
    {
        return $this->data->getString(self::KeyTest);
    }
}

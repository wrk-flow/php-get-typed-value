<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Transformers;

class TrimAndEmptyStringToNull extends TrimString
{
    public function transform(mixed $value, string $key): mixed
    {
        $value = parent::transform($value, $key);

        if ($value === '') {
            return null;
        }

        return $value;
    }
}

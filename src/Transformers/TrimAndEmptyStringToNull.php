<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Transformers;

use Wrkflow\GetValue\GetValue;

class TrimAndEmptyStringToNull extends TrimString
{
    public function transform(mixed $value, string $key, GetValue $getValue): mixed
    {
        $value = parent::transform($value, $key, $getValue);

        if ($value === '') {
            return null;
        }

        return $value;
    }
}

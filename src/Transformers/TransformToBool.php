<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Transformers;

use Wrkflow\GetValue\Contracts\TransformerContract;
use Wrkflow\GetValue\GetValue;

/**
 * Transforms most used representations of boolean in string or number ('yes','no',1,0,'1','0','true','false') and
 * converts it to bool.
 */
class TransformToBool implements TransformerContract
{
    public function beforeValidation(mixed $value, string $key): bool
    {
        return true;
    }

    public function transform(mixed $value, string $key, GetValue $getValue): mixed
    {
        // Ensure that value is boolean
        if ($value === 'true' || $value === true || $value === '1' || $value === 1 || $value === 'yes') {
            return true;
        } elseif ($value === 'false' || $value === false || $value === '0' || $value === 0 || $value === 'no') {
            return false;
        }

        return $value;
    }
}

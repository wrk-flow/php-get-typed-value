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
        if (in_array($value, ['true', true, '1', 1, 'yes'], true)) {
            return true;
        }
        if (in_array($value, ['false', false, '0', 0, 'no'], true)) {
            return false;
        }

        return $value;
    }
}

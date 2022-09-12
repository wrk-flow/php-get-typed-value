<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Contracts;

use Exception;

interface ExceptionBuilderContract
{
    public function missingValue(string $key): Exception;

    public function arrayIsEmpty(string $key): Exception;

    public function notAnArray(string $key): Exception;

    /**
     * @param class-string<RuleContract> $ruleClassName
     */
    public function validationFailed(string $key, string $ruleClassName, ?string $value): Exception;

    public function notXML(string $key): Exception;
}

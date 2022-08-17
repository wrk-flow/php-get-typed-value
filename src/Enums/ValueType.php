<?php

declare(strict_types=1);

namespace Wrkflow\GetValue\Enums;

enum ValueType
{
    case Int;
    case Float;
    case Bool;
    case String;
    case DateTime;
    case Array;
    case Object;
    case XMLAttributes;
}

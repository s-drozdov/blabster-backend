<?php

declare(strict_types=1);

namespace Blabster\Library\Enum;

enum PhpType: string
{
    case null = 'null';
    case array = 'array';
    case string = 'string';
    case int = 'int';
    case float = 'float';
    case bool = 'bool';
    case object = 'object';
    case callable = 'callable';
    case resource = 'resource';
}

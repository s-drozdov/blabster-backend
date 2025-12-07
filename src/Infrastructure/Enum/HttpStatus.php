<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Enum;

enum HttpStatus: int
{
    case OK = 200;
    case Created = 201;
    case Accepted = 202;
    case NoContent = 204;
    case BadRequest = 400;
    case Unauthorized = 401;
    case Forbidden = 403;
    case NotFound = 404;
    case MethodNotAllowed = 405;
    case ExpectationFailed = 417;
    case InternalServerError = 500;
}

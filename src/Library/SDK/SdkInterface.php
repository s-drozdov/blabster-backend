<?php

declare(strict_types=1);

namespace Blabster\Library\SDK;

interface SdkInterface
{
    public const string HEADER_CONTENT_TYPE = 'Content-Type';
    public const string HEADER_AUTHORIZATION = 'Authorization';

    public const string CONTENT_TYPE_FORM_URL_ENCODED = 'application/x-www-form-urlencoded';
    public const string CONTENT_TYPE_JSON = 'application/json';

    public const string AUTHORIZATION_BASIC = 'Basic';

    public const string ERROR_BAD_RESPONSE = 'Something went wrong. Bad response. Sorry, try again later.';
}

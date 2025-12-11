<?php

declare(strict_types=1);

namespace Blabster\Library\SDK\Turnsnile;

interface SdkInterface
{
    public const string HEADER_CONTENT_TYPE = 'Content-Type';
    public const string FORM_URL_ENCODED = 'application/x-www-form-urlencoded';
    public const string ERROR_BAD_RESPONSE = 'Something went wrong. Bad response. Sorry, try again later.';
}

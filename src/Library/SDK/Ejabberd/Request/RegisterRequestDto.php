<?php

declare(strict_types=1);

namespace Blabster\Library\SDK\Ejabberd\Request;

use Blabster\Library\SDK\SdkRequestDtoInterface;

final readonly class RegisterRequestDto implements SdkRequestDtoInterface
{
    public function __construct(
        public string $user,
        public string $host,
        public string $password,
    ) {
        /*_*/
    }
}

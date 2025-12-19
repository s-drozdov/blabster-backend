<?php

declare(strict_types=1);

namespace Blabster\Library\SDK\Ejabberd\Response;

final readonly class CheckAccountResponseDto
{
    public function __construct(
        public bool $is_user_exist,
    ) {
        /*_*/
    }
}

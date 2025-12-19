<?php

declare(strict_types=1);

namespace Blabster\Library\SDK\Ejabberd\Request;

use Blabster\Library\SDK\SdkRequestDtoInterface;

final readonly class AddRosterItemRequestDto implements SdkRequestDtoInterface
{
    public function __construct(
        public string $localuser,
        public string $localhost,
        public string $user,
        public string $host,
        public string $nick,

        /** @var array<string> $groups */
        public array $groups,
        
        public string $subs,
    ) {
        /*_*/
    }
}

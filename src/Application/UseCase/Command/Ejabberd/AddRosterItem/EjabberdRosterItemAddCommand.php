<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Command\Ejabberd\AddRosterItem;

use Blabster\Application\Bus\Command\CommandInterface;

final readonly class EjabberdRosterItemAddCommand implements CommandInterface
{
    public function __construct(
        public string $localuser,
        public string $localhost,
        public string $user,
        public string $host,
        public string $nick,

        /** @var array<string> $group_list */
        public array $group_list,
        
        public string $subs,
    ) {
        /*_*/
    }
}

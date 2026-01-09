<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Command\Ejabberd\Register;

use Blabster\Application\Bus\Command\CommandInterface;

final readonly class EjabberdRegisterCommand implements CommandInterface
{
    public function __construct(
        public string $user,
        public string $host,
        public string $password,
    ) {
        /*_*/
    }
}

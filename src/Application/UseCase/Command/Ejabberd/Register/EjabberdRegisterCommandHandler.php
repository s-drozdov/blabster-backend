<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Command\Ejabberd\Register;

use Override;
use Blabster\Application\Bus\CqrsElementInterface;
use Blabster\Library\SDK\Ejabberd\EjabberdSdkInterface;
use Blabster\Application\Bus\Command\CommandHandlerInterface;
use Blabster\Library\SDK\Ejabberd\Request\RegisterRequestDto;

/**
 * @implements CommandHandlerInterface<EjabberdRegisterCommand,EjabberdRegisterCommandResult>
 */
final readonly class EjabberdRegisterCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private EjabberdSdkInterface $ejabberdSdk,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): EjabberdRegisterCommandResult
    {
        $requestDto = new RegisterRequestDto(
            user: $command->user,
            host: $command->host,
            password: $command->password,
        );

        $this->ejabberdSdk->register($requestDto);

        return new EjabberdRegisterCommandResult();
    }
}

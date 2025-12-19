<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Bus;

use Override;
use Symfony\Component\Messenger\HandleTrait;
use Blabster\Application\Bus\Command\CommandBusInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Blabster\Application\Bus\Command\CommandInterface;
use Blabster\Application\Bus\Command\CommandResultInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

/**
 * @implements CommandBusInterface<CommandInterface, CommandResultInterface>
 */
final class CommandBus implements CommandBusInterface
{
    use HandleTrait;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
    }
    
    #[Override]
    public function execute($element): CommandResultInterface
    {
        try {
            /** @var CommandResultInterface @return */
            $result = $this->handle($element);

            return $result;
        } catch (HandlerFailedException $exception) {
            if (is_null($exception->getPrevious())) {
                throw $exception;
            }

            throw $exception->getPrevious();
        }
    }
}

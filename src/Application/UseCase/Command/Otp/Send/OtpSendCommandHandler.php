<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Command\Otp\Send;

use Override;
use Blabster\Application\Bus\CqrsElementInterface;
use Blabster\Application\Bus\Command\CommandHandlerInterface;
use Blabster\Application\UseCase\Command\Otp\Send\OtpSendCommand;
use Blabster\Application\UseCase\Command\Otp\Send\OtpSendCommandResult;

/**
 * @implements CommandHandlerInterface<OtpSendCommand,OtpSendCommandResult>
 */
final readonly class OtpSendCommandHandler implements CommandHandlerInterface
{
    public function __construct(
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $element): OtpSendCommandResult
    {
        return new OtpSendCommandResult(
            email: 'test@test.com',
        );
    }
}

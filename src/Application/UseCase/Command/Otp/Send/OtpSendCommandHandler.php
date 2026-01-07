<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Command\Otp\Send;

use Override;
use Blabster\Application\Bus\CqrsElementInterface;
use Blabster\Application\Bus\Command\CommandHandlerInterface;
use Blabster\Application\Service\Mail\Otp\OtpMailServiceInterface;

/**
 * @implements CommandHandlerInterface<OtpSendCommand,OtpSendCommandResult>
 */
final readonly class OtpSendCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private OtpMailServiceInterface $otpMailService,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): OtpSendCommandResult
    {
        $this->otpMailService->perform($command->otp_code, $command->email);

        return new OtpSendCommandResult();
    }
}

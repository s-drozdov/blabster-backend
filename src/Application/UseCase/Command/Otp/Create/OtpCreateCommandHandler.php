<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Command\Otp\Create;

use Override;
use Blabster\Application\Bus\CqrsElementInterface;
use Blabster\Domain\Service\Otp\Create\OtpCreateService;
use Blabster\Application\Bus\Command\CommandHandlerInterface;
use Blabster\Application\Service\Otp\Mail\OtpMailServiceInterface;
use Blabster\Domain\Service\Fingerprint\Match\FingerprintMatchService;
use Blabster\Domain\Service\Turnstile\Validation\TurnstileValidationService;
use Blabster\Domain\Service\PowChallenge\Validation\PowChallengeValidationService;

/**
 * @implements CommandHandlerInterface<OtpCreateCommand,OtpCreateCommandResult>
 */
final readonly class OtpCreateCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private PowChallengeValidationService $powChallengeValidationService,
        private FingerprintMatchService $fingerprintMatchService,
        private TurnstileValidationService $turnstileValidationService,
        private OtpCreateService $otpCreateService,
        private OtpMailServiceInterface $otpMailService,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): OtpCreateCommandResult
    {
        $fingerprint = $this->fingerprintMatchService->perform($command->fingerprint);
        $expiresAt = $fingerprint?->getExpiredAt();

        if ($expiresAt !== null) {
            return new OtpCreateCommandResult(
                email: $command->email,
                ban_expires_at: $expiresAt,
                otp_uuid: null,
            );
        }

        $this->performValidation($command);

        return $this->createOtp($command);
    }

    private function performValidation(OtpCreateCommand $command): void
    {
        $this->powChallengeValidationService->perform(
            $command->pow_challenge_uuid,
            $command->pow_challenge_nonce,
        );
        $this->turnstileValidationService->perform($command->turnstile_token);
    }

    private function createOtp(OtpCreateCommand $command): OtpCreateCommandResult
    {
        $otp = $this->otpCreateService->perform($command->email);
        $this->otpMailService->perform($otp->getCode(), $otp->getEmail());

        return new OtpCreateCommandResult(
            email: $command->email,
            ban_expires_at: null,
            otp_uuid: $otp->getUuid(),
        );
    }
}

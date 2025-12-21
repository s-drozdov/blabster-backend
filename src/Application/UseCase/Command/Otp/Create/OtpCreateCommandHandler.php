<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Command\Otp\Create;

use Override;
use Webmozart\Assert\Assert;
use Blabster\Application\Bus\CqrsElementInterface;
use Blabster\Library\SDK\Turnstile\TurnstileSdkInterface;
use Blabster\Application\Bus\Command\CommandHandlerInterface;
use Blabster\Domain\Service\Otp\Create\OtpCreateServiceInterface;
use Blabster\Application\Service\Otp\Mail\OtpMailServiceInterface;
use Blabster\Domain\Service\Fingerprint\Match\FingerprintMatchServiceInterface;
use Blabster\Domain\Service\PowChallenge\Validation\PowChallengeValidationServiceInterface;

/**
 * @implements CommandHandlerInterface<OtpCreateCommand,OtpCreateCommandResult>
 */
final readonly class OtpCreateCommandHandler implements CommandHandlerInterface
{
    private const string ERROR_VALIDATION = 'Validation was not passed.';

    public function __construct(
        private PowChallengeValidationServiceInterface $powChallengeValidationService,
        private FingerprintMatchServiceInterface $fingerprintMatchService,
        private TurnstileSdkInterface $turnstileSdk,
        private OtpCreateServiceInterface $otpCreateService,
        private OtpMailServiceInterface $otpMailService,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): OtpCreateCommandResult
    {
        $fingerprint = $this->fingerprintMatchService->perform($command->fingerprint);
        $expiresAt = $fingerprint?->getExpiresAt();

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

        $turnstileResultDto = $this->turnstileSdk->getResult($command->turnstile_token);
        Assert::true($turnstileResultDto->success, self::ERROR_VALIDATION);
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

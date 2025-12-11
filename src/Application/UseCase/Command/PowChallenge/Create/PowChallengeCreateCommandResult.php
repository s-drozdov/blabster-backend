<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Command\PowChallenge\Create;

use Blabster\Application\Bus\Command\CommandResultInterface;
use Blabster\Application\Dto\PowChallengeDto;

final readonly class PowChallengeCreateCommandResult implements CommandResultInterface
{
    public function __construct(
        public PowChallengeDto $pow_challenge,
    ) {
        /*_*/
    }
}

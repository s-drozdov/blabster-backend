<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Command\PowChallenge\Create;

use Override;
use Blabster\Application\Bus\CqrsElementInterface;
use Blabster\Application\Dto\Mapper\PowChallengeMapper;
use Blabster\Application\Bus\Command\CommandHandlerInterface;
use Blabster\Domain\Service\PowChallenge\Create\PowChallengeCreateService;

/**
 * @implements CommandHandlerInterface<PowChallengeCreateCommand,PowChallengeCreateCommandResult>
 */
final readonly class PowChallengeCreateCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private PowChallengeCreateService $powChallengeCreateService,
        private PowChallengeMapper $powChallengeMapper,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): PowChallengeCreateCommandResult
    {
        return new PowChallengeCreateCommandResult(
            pow_challenge: $this->powChallengeMapper->mapDomainObjectToDto(
                $this->powChallengeCreateService->perform(),
            ),
        );
    }
}

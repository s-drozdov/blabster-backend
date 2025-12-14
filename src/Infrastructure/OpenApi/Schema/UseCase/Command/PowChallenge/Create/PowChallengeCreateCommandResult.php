<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\OpenApi\Schema\UseCase\Command\PowChallenge\Create;

use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Attribute\Model;
use Blabster\Application\Dto\PowChallengeDto;
use Blabster\Infrastructure\OpenApi\Schema\Dto\PowChallenge\PowChallengeDto as PowChallengeDtoSchema;

/**
 * @psalm-suppress MissingConstructor
 */
#[OA\Schema()]
final class PowChallengeCreateCommandResult
{
    #[OA\Property(
        ref: new Model(type: PowChallengeDtoSchema::class)
    )]
    public PowChallengeDto $pow_challenge;
}

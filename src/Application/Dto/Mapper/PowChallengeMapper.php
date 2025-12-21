<?php

declare(strict_types=1);

namespace Blabster\Application\Dto\Mapper;

use Override;
use LogicException;
use Blabster\Library\Dto\DtoInterface;
use Blabster\Domain\Entity\PowChallenge;
use Blabster\Domain\DomainObjectInterface;
use Blabster\Application\Dto\PowChallengeDto;

/**
 * @psalm-suppress ClassMustBeFinal The class cannot be final because it is used as a test double in PHPUnit
 * 
 * @implements MapperInterface<PowChallenge,PowChallengeDto>
 */
readonly class PowChallengeMapper implements MapperInterface
{
    #[Override]
    public function mapDomainObjectToDto(DomainObjectInterface $object): PowChallengeDto
    {
        return new PowChallengeDto(
            uuid: $object->getUuid(),
            prefix: $object->getPrefix(),
            salt: $object->getSalt(),
            difficulty: $object->getDifficulty(),
            expires_at: $object->getExpiresAt(),
        );
    }

    #[Override]
    public function mapDtoToDomainObject(DtoInterface $dto): PowChallenge
    {
        throw new LogicException();
    }

    #[Override]
    public function getEntityType(): string
    {
        return PowChallenge::class;
    }

    #[Override]
    public function getDtoType(): string
    {
        return PowChallengeDto::class;
    }
}

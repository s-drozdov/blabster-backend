<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Repository;

use Override;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Blabster\Domain\Entity\User\RefreshToken;
use Blabster\Library\Helper\String\StringHelperInterface;
use Blabster\Domain\Repository\RefreshTokenRepositoryInterface;

/**
 * @extends EntityRepository<RefreshToken>
 */
final class RefreshTokenRepository extends EntityRepository implements RefreshTokenRepositoryInterface
{
    /** @use DoctrinePersistable<RefreshToken> */
    use DoctrinePersistable;

    public function __construct(
        EntityManagerInterface $entityManager,
        private StringHelperInterface $stringHelper,
    ) {
        parent::__construct($entityManager, $entityManager->getClassMetadata(RefreshToken::class));
    }

    #[Override]
    public function findByToken(string $value): ?RefreshToken
    {
        $entity = $this->createQueryBuilder('rt')
            ->andWhere('rt.value = :value')
            ->setParameter('value', $value)
            ->getQuery()
            ->getOneOrNullResult();

        /** @var ?RefreshToken $entity */
        return $entity;
    }

    #[Override]
    private function getStringHelper(): StringHelperInterface
    {
        return $this->stringHelper;
    }
}

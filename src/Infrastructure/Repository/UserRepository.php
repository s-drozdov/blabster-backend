<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Repository;

use Override;
use DateTimeImmutable;
use Webmozart\Assert\Assert;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityRepository;
use Blabster\Domain\Entity\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Blabster\Domain\Repository\UserRepositoryInterface;
use Blabster\Domain\Helper\String\StringHelperInterface;

/**
 * @extends EntityRepository<User>
 */
final class UserRepository extends EntityRepository implements UserRepositoryInterface
{
    /** @use DoctrinePersistable<User> */
    use DoctrinePersistable;

    public function __construct(
        EntityManagerInterface $entityManager,
        private StringHelperInterface $stringHelper,
    ) {
        parent::__construct($entityManager, $entityManager->getClassMetadata(User::class));
    }

    #[Override]
    public function findByEmail(string $email): ?User
    {
        $entity = $this->createQueryBuilder('u')
            ->andWhere('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();

        /** @var ?User $entity */
        return $entity;
    }


    #[Override]
    public function getByEmailAndToken(string $email, string $refreshTokenValue): User
    {
        $entity = $this->createQueryBuilder('u')
            ->innerJoin('u.refreshTokens', 'rt')
            ->andWhere('u.email = :email')
            ->andWhere('rt.value = :token')
            ->andWhere('rt.expires_at > :now')
            ->setParameter('email', $email)
            ->setParameter('token', $refreshTokenValue)
            ->setParameter('now', new DateTimeImmutable(), Types::DATETIME_IMMUTABLE)
            ->getQuery()
            ->getOneOrNullResult();
        
        Assert::notNull($entity);

        /** @var User $entity */
        return $entity;
    }

    #[Override]
    private function getStringHelper(): StringHelperInterface
    {
        return $this->stringHelper;
    }
}

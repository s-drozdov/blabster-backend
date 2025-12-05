<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Repository;

use Override;
use Doctrine\ORM\EntityManager;
use Blabster\Domain\Entity\User;
use Blabster\Domain\Repository\UserRepositoryInterface;

/**
 * @extends AbstractRepository<User>
 */
final class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    public function __construct(
        EntityManager $em,
    ) {
        parent::__construct($em, $em->getClassMetadata(User::class));
    }

    #[Override]
    public function findByEmail(string $email): ?User
    {
        $qb = $this->createQueryBuilder('u');

        $qb->where('u.email = :email')
            ->setParameter('email', $email);

        return $this->queryBuilderToEntity($qb);
    }
}

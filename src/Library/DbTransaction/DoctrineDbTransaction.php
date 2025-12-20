<?php

declare(strict_types=1);

namespace Blabster\Library\DbTransaction;

use Override;
use Throwable;
use Doctrine\ORM\EntityManagerInterface;

final readonly class DoctrineDbTransaction implements DbTransactionInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
        /*_*/
    }

    #[Override]
    public function start(?string $isolationLevel = null): void
    {
        $this->entityManager->beginTransaction();
    }

    #[Override]
    public function commit(): void
    {
        $this->entityManager->commit();
    }

    #[Override]
    public function rollback(): void
    {
        $this->entityManager->rollback();
    }

    #[Override]
    public function execute(callable $callback): mixed
    {
        $this->start();

        try {
            $result = $callback();

            $this->commit();

            return $result;
        } catch (Throwable $e) {
            $this->rollback();

            throw $e;
        }
    }
}

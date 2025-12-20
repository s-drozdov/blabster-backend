<?php

declare(strict_types=1);

namespace Blabster\Library\DbTransaction;

use Override;
use Throwable;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Blabster\Library\DbTransaction\Enum\IsolationLevel;
use Doctrine\DBAL\TransactionIsolationLevel;

final readonly class DoctrineDbTransaction implements DbTransactionInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private Connection $connection,
    ) {
        /*_*/
    }

    #[Override]
    public function start(?IsolationLevel $isolationLevel = null): void
    {
        if ($isolationLevel !== null) {
            $this->connection->setTransactionIsolation(
                $this->getDoctrineIsolationLevel($isolationLevel),
            );
        }

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
        } catch (Throwable $e) {
            $this->rollback();

            throw $e;
        }

        return $result;
    }

    private function getDoctrineIsolationLevel(IsolationLevel $isolationLevel): TransactionIsolationLevel
    {
        return match ($isolationLevel) {
            IsolationLevel::READ_UNCOMMITTED => TransactionIsolationLevel::READ_UNCOMMITTED,
            IsolationLevel::READ_COMMITTED => TransactionIsolationLevel::READ_COMMITTED,
            IsolationLevel::REPEATABLE_READ => TransactionIsolationLevel::REPEATABLE_READ,
            IsolationLevel::SERIALIZABLE => TransactionIsolationLevel::SERIALIZABLE,
        };
    }
}

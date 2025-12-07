<?php

declare(strict_types=1);

namespace Blabster\Library\DbTransaction;

use Override;
use Throwable;
use Blabster\Library\DbTransaction\DbTransactionInterface;

final readonly class FakeDbTransaction implements DbTransactionInterface
{
    #[Override]
    public function start(?string $isolationLevel = null): void
    {
        /*_*/
    }

    #[Override]
    public function commit(): void
    {
        /*_*/
    }

    #[Override]
    public function rollback(): void
    {
        /*_*/
    }

    /**
     * @param callable(): void $callback
     * 
     * @throws Throwable
     */
    #[Override]
    public function execute(callable $callback): void
    {
        $this->start();

        try {
            $callback();

            $this->commit();
        } catch (Throwable $e) {
            $this->rollback();

            throw $e;
        }
    }
}

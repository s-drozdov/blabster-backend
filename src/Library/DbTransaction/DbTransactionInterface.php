<?php

declare(strict_types=1);

namespace Blabster\Library\DbTransaction;

use Throwable;

interface DbTransactionInterface
{
    public const string ISOLATION_LEVEL_READ_UNCOMMITTED = 'read_uncommited';
    public const string ISOLATION_LEVEL_READ_COMMITTED = 'read_committed';
    public const string ISOLATION_LEVEL_REPEATABLE_READ = 'repeatable_read';
    public const string ISOLATION_LEVEL_SERIALIZABLE = 'serializable';
    
    public function start(?string $isolationLevel = null): void;

    public function commit(): void;

    public function rollback(): void;

    /**
     * @param callable(): void $callback
     * 
     * @throws Throwable
     */
    public function execute(callable $callback): void;
}

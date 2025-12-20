<?php

declare(strict_types=1);

namespace Blabster\Library\DbTransaction;

use Blabster\Library\DbTransaction\Enum\IsolationLevel;
use Throwable;

interface DbTransactionInterface
{
    public function start(?IsolationLevel $isolationLevel = null): void;

    public function commit(): void;

    public function rollback(): void;

    /**
     * @template T
     * 
     * @param callable(): T $callback
     * 
     * @return T
     * @throws Throwable
     */
    public function execute(callable $callback): mixed;
}

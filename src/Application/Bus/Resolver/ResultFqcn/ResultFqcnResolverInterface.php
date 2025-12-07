<?php

declare(strict_types=1);

namespace Blabster\Application\Bus\Resolver\ResultFqcn;

use InvalidArgumentException;

interface ResultFqcnResolverInterface
{
    /**
     * @param class-string $cqrsElementFqcn
     * 
     * @throws InvalidArgumentException
     */
    public function resolve(string $cqrsElementFqcn): string;
}

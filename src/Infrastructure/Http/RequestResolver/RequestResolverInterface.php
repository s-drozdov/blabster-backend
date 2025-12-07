<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Http\RequestResolver;

use LogicException;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;
use Blabster\Application\Bus\CqrsElementInterface;

interface RequestResolverInterface
{
    /**
     * @param class-string<CqrsElementInterface> $cqrsElementFqcn
     * @param array<array-key,mixed> $args
     * 
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    public function resolve(string $cqrsElementFqcn, ServerRequestInterface $request, array $args): CqrsElementInterface;
}

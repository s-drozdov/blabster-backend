<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Http\RequestResolver;

use Override;
use DI\Container;
use LogicException;
use Psr\Http\Message\ServerRequestInterface;
use Blabster\Application\Bus\CqrsElementInterface;

final readonly class RequestResolver implements RequestResolverInterface
{
    private const string CANNOT_FIND_REQUEST_RESOLVER = 'Cannot find request resolver for %s';

    public function __construct(
        /** @var array<class-string<CqrsElementInterface>,class-string<RequestResolverInterface>> $cqrsElementToResolverMap */
        private array $cqrsElementToResolverMap,

        private Container $container,
    ) {
        /*_*/
    }

    #[Override]
    public function resolve(string $cqrsElementFqcn, ServerRequestInterface $request, array $args): CqrsElementInterface
    {
        if (!isset($this->cqrsElementToResolverMap[$cqrsElementFqcn])) {
            throw new LogicException(
                sprintf(self::CANNOT_FIND_REQUEST_RESOLVER, $cqrsElementFqcn),
            );
        }
        
        /** @var RequestResolverInterface $resolver */
        $resolver = $this->container->get(
            $this->cqrsElementToResolverMap[$cqrsElementFqcn]
        );

        return $resolver->resolve($cqrsElementFqcn, $request, $args);
    }
}

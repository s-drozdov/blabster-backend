<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Bootstrap;

use Override;
use Slim\App;
use Psr\Http\Server\MiddlewareInterface;

final readonly class MiddlewareBootstrap implements BootstrapInterface
{
    public function __construct(
        /** @var array<array-key,class-string<MiddlewareInterface>> $middlewareList */
        private array $middlewareList,
    ){
        /*_*/
    }

    #[Override]
    public function perform(App $app): void
    {
        foreach ($this->middlewareList as $middleware) {
            $app->add($middleware);
        }
    }
}

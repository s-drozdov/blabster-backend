<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Bootstrap;

use Override;
use Slim\App;

final readonly class Bootstrap implements BootstrapInterface
{
    public function __construct(
        /** @var array<array-key,BootstrapInterface> $bootstrapList */
        private array $bootstrapList,
    ){
        /*_*/
    }

    #[Override]
    public function perform(App $app): void
    {
        foreach ($this->bootstrapList as $bootstrap) {
            $bootstrap->perform($app);
        }
    }
}

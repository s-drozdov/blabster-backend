<?php

declare(strict_types=1);

namespace Blabster\Backend\Infrastructure\Http\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Override;

final readonly class RootAction implements ActionInterface
{
    #[Override]
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $response->getBody()->write("Hello world!");
        
        return $response;
    }
}

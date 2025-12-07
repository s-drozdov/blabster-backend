<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Bootstrap;

use Override;
use Slim\App;
use Slim\Handlers\ErrorHandler;
use Slim\Error\Renderers\JsonErrorRenderer;
use Blabster\Infrastructure\Enum\ContentType;

final readonly class ErrorBootstrap implements BootstrapInterface
{
    public function __construct(
        private bool $isDebug,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(App $app): void
    {
        $errorMiddleware = $app->addErrorMiddleware($this->isDebug, true, true);

        /** @var ErrorHandler $errorHandler */
        $errorHandler = $errorMiddleware->getDefaultErrorHandler();

        $errorHandler->forceContentType(ContentType::json->value);
        $errorHandler->registerErrorRenderer(ContentType::json->value, JsonErrorRenderer::class);
    }
}

<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Middleware;

use Override;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Blabster\Infrastructure\Enum\HttpStatus;
use Blabster\Infrastructure\Enum\ContentType;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ServerRequestInterface as RequestInterface;

final readonly class JsonBodyParserMiddleware implements MiddlewareInterface
{
    public function __construct(
        private ResponseFactoryInterface $responseFactory,
    ) {
        /*_*/
    }

    #[Override]
    public function process(RequestInterface $request, RequestHandler $handler): ResponseInterface
    {
        $contentType = $request->getHeaderLine('Content-Type');

        if (strstr($contentType, ContentType::json->value) === false) {
            return $this->responseFactory->createResponse(HttpStatus::BadRequest->value);
        }

        $request = $this->patchRequest($request);

        return $handler->handle($request);
    }

    private function patchRequest(RequestInterface $request): RequestInterface
    {
        $rawBody = file_get_contents('php://input');

        if ($rawBody === false) {
            return $request->withParsedBody([]);
        }

        $contents = json_decode($rawBody, true);
        
        if (json_last_error() === JSON_ERROR_NONE) {
            /** @var array<array-key,mixed> $contents */
            return $request->withParsedBody($contents);
        }

        return $request->withParsedBody([]);
    }
}

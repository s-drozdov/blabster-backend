<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Event\Subscriber\Exception\EventResponse;

use Override;
use Throwable;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Mezzio\ProblemDetails\ProblemDetailsResponseFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Bridge\PsrHttpMessage\HttpFoundationFactoryInterface;

final class DefaultEventResponseProvider implements EventResponseProviderInterface
{
    public function __construct(
        private ProblemDetailsResponseFactory $problemDetailsResponseFactory,
        private HttpFoundationFactoryInterface $httpFoundationFactory,
        private PsrHttpFactory $psrHttpFactory,
    ) {
        /*_*/
    }

    #[Override]
    public function get(ExceptionEvent $event): Response
    {
        $exception = $event->getThrowable();
        $statusCode = $this->getStatusCode($exception);

        $psrResponse = $this->problemDetailsResponseFactory->createResponse(
            $this->psrHttpFactory->createRequest(
                $event->getRequest(),
            ),
            $statusCode,
            $exception->getMessage(),
        );

        $symfonyResponse = $this->httpFoundationFactory->createResponse($psrResponse);
        $symfonyResponse->setStatusCode($statusCode);

        return $symfonyResponse;
    }

    private function getStatusCode(Throwable $exception): int
    {
        if ($exception instanceof InvalidArgumentException) {
            return Response::HTTP_UNPROCESSABLE_ENTITY;
        }

        if (method_exists($exception, 'getStatusCode')) {
            return $exception->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return empty($exception->getCode()) 
            ? Response::HTTP_INTERNAL_SERVER_ERROR 
            : (int) $exception->getCode();
    }
}

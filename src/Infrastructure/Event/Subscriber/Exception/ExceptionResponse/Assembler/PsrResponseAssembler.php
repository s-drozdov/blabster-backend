<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Event\Subscriber\Exception\ExceptionResponse\Assembler;

use Throwable;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Mezzio\ProblemDetails\ProblemDetailsResponseFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Blabster\Library\Assembler\AssemblerInterface;
use Blabster\Infrastructure\Event\Subscriber\Exception\ExceptionResponse\Dto\ExceptionResponseAdditionalDto;

final class PsrResponseAssembler implements AssemblerInterface
{
    public function __construct(
        private ProblemDetailsResponseFactory $problemDetailsResponseFactory,
        private PsrHttpFactory $psrHttpFactory,
    ) {
        /*_*/
    }

    public function assemble(
        Throwable $exception,
        Request $request,
        ExceptionResponseAdditionalDto $additionalDto
    ): ResponseInterface {
        return $this->problemDetailsResponseFactory->createResponse(
            request: $this->psrHttpFactory->createRequest($request),
            status: Response::HTTP_UNPROCESSABLE_ENTITY,
            detail: $exception->getMessage(),
            additional: $additionalDto->toArray(),
        );
    }
}

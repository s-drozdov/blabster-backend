<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Event\Subscriber\Exception\ExceptionResponse;

use Override;
use Throwable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bridge\PsrHttpMessage\HttpFoundationFactoryInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Blabster\Infrastructure\Event\Subscriber\Exception\ExceptionResponse\Assembler\PsrResponseAssembler;
use Blabster\Infrastructure\Event\Subscriber\Exception\ExceptionResponse\Dto\ExceptionResponseAdditionalDto;

/**
 * @implements ExceptionResponseProviderInterface<ValidationFailedException>
 */
final class ValidationFailedResponseProvider implements ExceptionResponseProviderInterface
{
    public function __construct(
        private HttpFoundationFactoryInterface $httpFoundationFactory,
        private PsrResponseAssembler $psrResponseAssembler,
    ) {
        /*_*/
    }

    /**
     * @inheritdoc
     */
    #[Override]
    public function get(Throwable $exception, Request $request): Response
    {
        return $this->httpFoundationFactory->createResponse(
            $this->psrResponseAssembler->assemble($exception, $request, $this->getAdditionalDto($exception)),
        );
    }

    private function getAdditionalDto(ValidationFailedException $exception): ExceptionResponseAdditionalDto
    {
        $errors = [];

        foreach ($exception->getViolations() as $violation) {
            $errors[$violation->getPropertyPath()][] = $violation->getMessage();
        }

        return new ExceptionResponseAdditionalDto(
            errors: $errors,
        );
    }
}

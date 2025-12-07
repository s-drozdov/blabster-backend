<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Event\Subscriber\Exception\ExceptionResponse;

use Override;
use Throwable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bridge\PsrHttpMessage\HttpFoundationFactoryInterface;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Blabster\Infrastructure\Event\Subscriber\Exception\ExceptionResponse\Assembler\PsrResponseAssembler;
use Blabster\Infrastructure\Event\Subscriber\Exception\ExceptionResponse\Dto\ExceptionResponseAdditionalDto;

/**
 * @implements ExceptionResponseProviderInterface<NotNormalizableValueException>
 */
final class NotNormalizableValueResponseProvider implements ExceptionResponseProviderInterface
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
    public function get(Throwable $exception, Request $request): ?Response
    {
        $attribute = $exception->getPath();

        if (is_null($attribute)) {
            return null;
        }

        $additionalDto = new ExceptionResponseAdditionalDto(
            errors: [$attribute => [$exception->getMessage()]],
        );

        return $this->httpFoundationFactory->createResponse(
            $this->psrResponseAssembler->assemble($exception, $request, $additionalDto),
        );
    }
}

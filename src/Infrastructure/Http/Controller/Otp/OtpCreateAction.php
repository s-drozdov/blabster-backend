<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Http\Controller\Otp;

use Blabster\Infrastructure\Enum\Action;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Blabster\Application\Bus\CommandBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Blabster\Library\Enum\SerializationContextParam;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Blabster\Application\UseCase\Command\Otp\Create\OtpCreateCommand;
use Blabster\Application\UseCase\Command\Otp\Create\OtpCreateCommandResult;

#[AsController]
#[Route(Action::otp_create->value, name: Action::otp_create->name, methods: [Request::METHOD_POST])]
final class OtpCreateAction
{
    public function __construct(

        /** @var CommandBusInterface<OtpCreateCommand,OtpCreateCommandResult> */
        private CommandBusInterface $commandBus,

        private SerializerInterface $serializer,
    ){
        /*_*/
    }

    public function __invoke(OtpCreateCommand $command): Response
    {
        return JsonResponse::fromJsonString(
            $this->serializer->serialize(
                $this->commandBus->execute($command),
                JsonEncoder::FORMAT,
                [SerializationContextParam::isHttpResponse->value => true],
            ),
            Response::HTTP_ACCEPTED,
        );
    }
}

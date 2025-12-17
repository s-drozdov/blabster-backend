<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Http\Controller\Otp\Create;

use OpenApi\Attributes as OA;
use Blabster\Infrastructure\Enum\Action;
use Nelmio\ApiDocBundle\Attribute\Model;
use Blabster\Infrastructure\Enum\OpenApiTag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Blabster\Infrastructure\Enum\OpenApiSummary;
use Blabster\Application\Bus\CommandBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Blabster\Infrastructure\Enum\OpenApiOperationId;
use Blabster\Library\Enum\SerializationContextParam;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Blabster\Infrastructure\Enum\OpenApiSchemaDescription;
use Blabster\Application\UseCase\Command\Otp\Create\OtpCreateCommand;
use Blabster\Application\UseCase\Command\Otp\Create\OtpCreateCommandResult;
use Blabster\Infrastructure\OpenApi\Schema\UseCase\Command\Otp\Create\OtpCreateCommand as OtpCreateCommandSchema;
use Blabster\Infrastructure\OpenApi\Schema\UseCase\Command\Otp\Create\OtpCreateCommandResult as OtpCreateCommandResultSchema;

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

    #[OA\Post(
        path: Action::otp_create->value,
        operationId: OpenApiOperationId::OtpCreate->value,
        summary: OpenApiSummary::OtpCreate->value,
        tags: [OpenApiTag::Otp->value],
        requestBody: new OA\RequestBody(
            required: true,
            description: OpenApiSchemaDescription::OtpCreateCommand->value,
            content: new OA\JsonContent(
                ref: new Model(type: OtpCreateCommandSchema::class),
            ),
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_ACCEPTED,
                description: OpenApiSchemaDescription::OtpCreateCommandResult->value,
                content: new OA\JsonContent(
                    ref: new Model(type: OtpCreateCommandResultSchema::class),
                ),
            ),
        ],
    )]
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

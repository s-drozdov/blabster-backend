<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Http\Controller\Auth\Logout;

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
use Blabster\Application\UseCase\Command\Auth\Logout\AuthLogoutCommand;
use Blabster\Application\UseCase\Command\Auth\Logout\AuthLogoutCommandResult;
use Blabster\Infrastructure\OpenApi\Schema\UseCase\Command\Auth\Logout\AuthLogoutCommand as AuthLogoutCommandSchema;
use Blabster\Infrastructure\OpenApi\Schema\UseCase\Command\Auth\Logout\AuthLogoutCommandResult as AuthLogoutCommandResultSchema;

#[AsController]
#[Route(Action::auth_logout->value, name: Action::auth_logout->name, methods: [Request::METHOD_POST])]
final class LogoutAction
{
    public function __construct(

        /** @var CommandBusInterface<AuthLogoutCommand,AuthLogoutCommandResult> */
        private CommandBusInterface $commandBus,

        private SerializerInterface $serializer,
    ){
        /*_*/
    }

    #[OA\Post(
        path: Action::auth_logout->value,
        operationId: OpenApiOperationId::AuthLogout->value,
        summary: OpenApiSummary::AuthLogout->value,
        tags: [OpenApiTag::Auth->value],
        requestBody: new OA\RequestBody(
            required: true,
            description: OpenApiSchemaDescription::AuthLogoutCommand->value,
            content: new OA\JsonContent(
                ref: new Model(type: AuthLogoutCommandSchema::class),
            ),
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: OpenApiSchemaDescription::AuthLogoutCommandResult->value,
                content: new OA\JsonContent(
                    ref: new Model(type: AuthLogoutCommandResultSchema::class),
                ),
            ),
        ],
    )]
    public function __invoke(AuthLogoutCommand $command): Response
    {
        return JsonResponse::fromJsonString(
            $this->serializer->serialize(
                $this->commandBus->execute($command),
                JsonEncoder::FORMAT,
                [SerializationContextParam::isHttpResponse->value => true],
            ),
            Response::HTTP_OK,
        );
    }
}

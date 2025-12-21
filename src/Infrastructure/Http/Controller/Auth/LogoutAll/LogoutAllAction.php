<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Http\Controller\Auth\LogoutAll;

use OpenApi\Attributes as OA;
use Blabster\Infrastructure\Enum\Action;
use Nelmio\ApiDocBundle\Attribute\Model;
use Blabster\Infrastructure\Enum\OpenApiTag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Blabster\Infrastructure\Enum\OpenApiSummary;
use Blabster\Application\Bus\Command\CommandBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Blabster\Infrastructure\Enum\OpenApiOperationId;
use Blabster\Library\Enum\SerializationContextParam;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Blabster\Infrastructure\Enum\OpenApiSchemaDescription;
use Blabster\Application\UseCase\Command\User\LogoutAll\UserLogoutAllCommand;
use Blabster\Application\UseCase\Command\User\LogoutAll\UserLogoutAllCommandResult;
use Blabster\Infrastructure\OpenApi\Schema\UseCase\Command\User\LogoutAll\UserLogoutAllCommand as UserLogoutAllCommandSchema;
use Blabster\Infrastructure\OpenApi\Schema\UseCase\Command\User\LogoutAll\UserLogoutAllCommandResult as UserLogoutAllCommandResultSchema;

#[AsController]
#[Route(Action::auth_logout_all->value, name: Action::auth_logout_all->name, methods: [Request::METHOD_POST])]
final class LogoutAllAction
{
    public function __construct(

        /** @var CommandBusInterface<UserLogoutAllCommand,UserLogoutAllCommandResult> */
        private CommandBusInterface $commandBus,

        private SerializerInterface $serializer,
    ) {
        /*_*/
    }

    #[OA\Post(
        path: Action::auth_logout_all->value,
        operationId: OpenApiOperationId::AuthLogoutAll->value,
        summary: OpenApiSummary::AuthLogoutAll->value,
        tags: [OpenApiTag::Auth->value],
        requestBody: new OA\RequestBody(
            required: true,
            description: OpenApiSchemaDescription::UserLogoutAllCommand->value,
            content: new OA\JsonContent(
                ref: new Model(type: UserLogoutAllCommandSchema::class),
            ),
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: OpenApiSchemaDescription::UserLogoutAllCommandResult->value,
                content: new OA\JsonContent(
                    ref: new Model(type: UserLogoutAllCommandResultSchema::class),
                ),
            ),
        ],
    )]
    public function __invoke(UserLogoutAllCommand $command): Response
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

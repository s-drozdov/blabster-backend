<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Http\Controller\User\Logout;

use OpenApi\Attributes as OA;
use Blabster\Infrastructure\Enum\Action;
use Nelmio\ApiDocBundle\Attribute\Model;
use Blabster\Infrastructure\Enum\Resource;
use Blabster\Infrastructure\Enum\CookieKey;
use Blabster\Infrastructure\Enum\OpenApiTag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Blabster\Infrastructure\Enum\OpenApiSummary;
use Symfony\Component\HttpFoundation\JsonResponse;
use Blabster\Infrastructure\Enum\OpenApiOperationId;
use Blabster\Library\Enum\SerializationContextParam;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Blabster\Application\Bus\Command\CommandBusInterface;
use Blabster\Infrastructure\Enum\OpenApiSchemaDescription;
use Blabster\Application\UseCase\Command\User\Logout\UserLogoutCommand;
use Blabster\Application\UseCase\Command\User\Logout\UserLogoutCommandResult;
use Blabster\Infrastructure\OpenApi\Schema\UseCase\Command\User\Logout\UserLogoutCommand as UserLogoutCommandSchema;
use Blabster\Infrastructure\OpenApi\Schema\UseCase\Command\User\Logout\UserLogoutCommandResult as UserLogoutCommandResultSchema;

#[AsController]
#[Route(Action::user_logout->value, name: Action::user_logout->name, methods: [Request::METHOD_POST])]
final class LogoutAction
{
    public function __construct(

        /** @var CommandBusInterface<UserLogoutCommand,UserLogoutCommandResult> */
        private CommandBusInterface $commandBus,

        private SerializerInterface $serializer,
    ) {
        /*_*/
    }

    #[OA\Post(
        path: Action::user_logout->value,
        operationId: OpenApiOperationId::UserLogout->value,
        summary: OpenApiSummary::UserLogout->value,
        tags: [OpenApiTag::User->value],
        requestBody: new OA\RequestBody(
            required: true,
            description: OpenApiSchemaDescription::UserLogoutCommand->value,
            content: new OA\JsonContent(
                ref: new Model(type: UserLogoutCommandSchema::class),
            ),
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: OpenApiSchemaDescription::UserLogoutCommandResult->value,
                content: new OA\JsonContent(
                    ref: new Model(type: UserLogoutCommandResultSchema::class),
                ),
            ),
        ],
    )]
    public function __invoke(UserLogoutCommand $command): Response
    {
        $response = JsonResponse::fromJsonString(
            $this->serializer->serialize(
                $this->commandBus->execute($command),
                JsonEncoder::FORMAT,
                [SerializationContextParam::isHttpResponse->value => true],
            ),
            Response::HTTP_OK,
        );

        $response->headers->removeCookie(
            CookieKey::RefreshToken->value, 
            Resource::Refresh->value,
        );

        return $response;
    }
}

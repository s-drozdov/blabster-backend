<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Http\Controller\User\Login;

use OpenApi\Attributes as OA;
use Blabster\Infrastructure\Enum\Action;
use Nelmio\ApiDocBundle\Attribute\Model;
use Blabster\Infrastructure\Enum\Resource;
use Blabster\Infrastructure\Enum\SameSite;
use Blabster\Infrastructure\Enum\CookieKey;
use Blabster\Infrastructure\Enum\OpenApiTag;
use Symfony\Component\HttpFoundation\Cookie;
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
use Blabster\Application\UseCase\Command\User\Login\UserLoginCommand;
use Blabster\Application\UseCase\Command\User\Login\UserLoginCommandResult;
use Blabster\Infrastructure\OpenApi\Schema\UseCase\Command\User\Login\UserLoginCommand as UserLoginCommandSchema;
use Blabster\Infrastructure\OpenApi\Schema\UseCase\Command\User\Login\UserLoginCommandResult as UserLoginCommandResultSchema;

#[AsController]
#[Route(Action::user_login->value, name: Action::user_login->name, methods: [Request::METHOD_POST])]
final class LoginAction
{
    public function __construct(

        /** @var CommandBusInterface<UserLoginCommand,UserLoginCommandResult> */
        private CommandBusInterface $commandBus,

        private SerializerInterface $serializer,
        private bool $isRefreshTokenCookieSameSiteStrict,
        private bool $isCookieSecure,
    ) {
        /*_*/
    }

    #[OA\Post(
        path: Action::user_login->value,
        operationId: OpenApiOperationId::UserLogin->value,
        summary: OpenApiSummary::UserLogin->value,
        tags: [OpenApiTag::User->value],
        requestBody: new OA\RequestBody(
            required: true,
            description: OpenApiSchemaDescription::UserLoginCommand->value,
            content: new OA\JsonContent(
                ref: new Model(type: UserLoginCommandSchema::class),
            ),
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: OpenApiSchemaDescription::UserLoginCommandResult->value,
                content: new OA\JsonContent(
                    ref: new Model(type: UserLoginCommandResultSchema::class),
                ),
            ),
        ],
    )]
    public function __invoke(UserLoginCommand $command): Response
    {
        /** @var UserLoginCommandResult $result */
        $result = $this->commandBus->execute($command);

        $response = JsonResponse::fromJsonString(
            $this->serializer->serialize(
                ['access_token' => $result->access_token],
                JsonEncoder::FORMAT,
                [SerializationContextParam::isHttpResponse->value => true],
            ),
            Response::HTTP_OK,
        );

        $refreshTokenCookie = Cookie::create(CookieKey::RefreshToken->value)
            ->withValue($result->refresh_token_value)
            ->withHttpOnly(true)
            ->withSecure($this->isCookieSecure)
            ->withSameSite($this->isRefreshTokenCookieSameSiteStrict ? SameSite::Strict->value : SameSite::None->value)
            ->withPath(Resource::Refresh->value)
            ->withExpires($result->refresh_token_expires_at);

        $response->headers->setCookie($refreshTokenCookie);

        return $response;
    }
}

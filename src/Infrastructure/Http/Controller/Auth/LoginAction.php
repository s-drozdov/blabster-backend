<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Http\Controller\Auth;

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
use Blabster\Application\Bus\CommandBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Blabster\Infrastructure\Enum\OpenApiOperationId;
use Blabster\Library\Enum\SerializationContextParam;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Blabster\Infrastructure\Enum\OpenApiSchemaDescription;
use Blabster\Application\UseCase\Command\Auth\Login\AuthLoginCommand;
use Blabster\Application\UseCase\Command\Auth\Login\AuthLoginCommandResult;
use Blabster\Infrastructure\OpenApi\Schema\UseCase\Command\Auth\Login\AuthLoginCommand as AuthLoginCommandSchema;
use Blabster\Infrastructure\OpenApi\Schema\UseCase\Command\Auth\Login\AuthLoginCommandResult as AuthLoginCommandResultSchema;

#[AsController]
#[Route(Action::auth_login->value, name: Action::auth_login->name, methods: [Request::METHOD_POST])]
final class LoginAction
{
    public function __construct(

        /** @var CommandBusInterface<AuthLoginCommand,AuthLoginCommandResult> */
        private CommandBusInterface $commandBus,

        private SerializerInterface $serializer,
        private bool $isCookieSecure,
    ){
        /*_*/
    }

    #[OA\Post(
        path: Action::auth_login->value,
        operationId: OpenApiOperationId::AuthLogin->value,
        summary: OpenApiSummary::AuthLogin->value,
        tags: [OpenApiTag::Auth->value],
        requestBody: new OA\RequestBody(
            required: true,
            description: OpenApiSchemaDescription::AuthLoginCommand->value,
            content: new OA\JsonContent(
                ref: new Model(type: AuthLoginCommandSchema::class),
            ),
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: OpenApiSchemaDescription::AuthLoginCommandResult->value,
                content: new OA\JsonContent(
                    ref: new Model(type: AuthLoginCommandResultSchema::class),
                ),
            ),
        ],
    )]
    public function __invoke(AuthLoginCommand $command): Response
    {
        /** @var AuthLoginCommandResult $result */
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
            ->withSameSite(SameSite::Strict->value)
            ->withPath(Resource::Refresh->value)
            ->withExpires($result->refresh_token_expires_at);

        $response->headers->setCookie($refreshTokenCookie);

        return $response;
    }
}

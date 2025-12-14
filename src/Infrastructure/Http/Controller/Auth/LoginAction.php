<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Http\Controller\Auth;

use Blabster\Infrastructure\Enum\Action;
use Blabster\Infrastructure\Enum\Resource;
use Blabster\Infrastructure\Enum\SameSite;
use Blabster\Infrastructure\Enum\CookieKey;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Blabster\Application\Bus\CommandBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Blabster\Library\Enum\SerializationContextParam;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Blabster\Application\UseCase\Command\Auth\Login\AuthLoginCommand;
use Blabster\Application\UseCase\Command\Auth\Login\AuthLoginCommandResult;

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

    public function __invoke(AuthLoginCommand $command): Response
    {
        /** @var AuthLoginCommandResult $result */
        $result = $this->commandBus->execute($command);

        $response = JsonResponse::fromJsonString(
            $this->serializer->serialize(
                $result,
                JsonEncoder::FORMAT,
                [SerializationContextParam::isHttpResponse->value => true],
            ),
            Response::HTTP_CREATED,
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

<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Http\Controller\Auth\Refresh;

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
use Blabster\Application\UseCase\Command\Auth\Refresh\AuthRefreshCommand;
use Blabster\Application\UseCase\Command\Auth\Refresh\AuthRefreshCommandResult;
use Blabster\Infrastructure\OpenApi\Schema\UseCase\Command\Auth\Refresh\AuthRefreshCommand as AuthRefreshCommandSchema;
use Blabster\Infrastructure\OpenApi\Schema\UseCase\Command\Auth\Refresh\AuthRefreshCommandResult as AuthRefreshCommandResultSchema;

#[AsController]
#[Route(Action::auth_refresh->value, name: Action::auth_refresh->name, methods: [Request::METHOD_POST])]
final class RefreshAction
{
    public function __construct(

        /** @var CommandBusInterface<AuthRefreshCommand,AuthRefreshCommandResult> */
        private CommandBusInterface $commandBus,

        private SerializerInterface $serializer,
    ){
        /*_*/
    }

    #[OA\Post(
        path: Action::auth_refresh->value,
        operationId: OpenApiOperationId::AuthRefresh->value,
        summary: OpenApiSummary::AuthRefresh->value,
        tags: [OpenApiTag::Auth->value],
        requestBody: new OA\RequestBody(
            required: true,
            description: OpenApiSchemaDescription::AuthRefreshCommand->value,
            content: new OA\JsonContent(
                ref: new Model(type: AuthRefreshCommandSchema::class),
            ),
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: OpenApiSchemaDescription::AuthRefreshCommandResult->value,
                content: new OA\JsonContent(
                    ref: new Model(type: AuthRefreshCommandResultSchema::class),
                ),
            ),
        ],
    )]
    public function __invoke(AuthRefreshCommand $command): Response
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

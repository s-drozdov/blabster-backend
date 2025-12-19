<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Http\Controller\MessengerAccount;

use OpenApi\Attributes as OA;
use Blabster\Infrastructure\Enum\Action;
use Nelmio\ApiDocBundle\Attribute\Model;
use Blabster\Infrastructure\Enum\OpenApiTag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Blabster\Infrastructure\Enum\OpenApiSummary;
use Symfony\Component\HttpFoundation\JsonResponse;
use Blabster\Infrastructure\Enum\OpenApiOperationId;
use Blabster\Library\Enum\SerializationContextParam;
use Blabster\Application\Bus\Query\QueryBusInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Blabster\Application\Bus\Query\CommandBusInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Blabster\Infrastructure\Enum\OpenApiSchemaDescription;
use Blabster\Application\UseCase\Query\MessengerAccount\MessengerAccountQuery;
use Blabster\Application\UseCase\Query\MessengerAccount\MessengerAccountQueryResult;
use Blabster\Infrastructure\OpenApi\Schema\UseCase\Query\MessengerAccount\MessengerAccountQuery as MessengerAccountQuerySchema;
use Blabster\Infrastructure\OpenApi\Schema\UseCase\Query\MessengerAccount\MessengerAccountQueryResult as MessengerAccountQueryResultSchema;

#[AsController]
#[Route(Action::messenger_account_get->value, name: Action::messenger_account_get->name, methods: [Request::METHOD_GET])]
final class MessengerAccountGetAction
{
    public function __construct(

        /** @var QueryBusInterface<MessengerAccountQuery,MessengerAccountQueryResult> */
        private QueryBusInterface $queryBus,

        private SerializerInterface $serializer,
    ){
        /*_*/
    }

    #[OA\Get(
        path: Action::messenger_account_get->value,
        operationId: OpenApiOperationId::MessengerAccountGet->value,
        summary: OpenApiSummary::MessengerAccountGet->value,
        tags: [OpenApiTag::MessengerAccount->value],
        requestBody: new OA\RequestBody(
            required: true,
            description: OpenApiSchemaDescription::MessengerAccountQuery->value,
            content: new OA\JsonContent(
                ref: new Model(type: MessengerAccountQuerySchema::class),
            ),
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: OpenApiSchemaDescription::MessengerAccountQueryResult->value,
                content: new OA\JsonContent(
                    ref: new Model(type: MessengerAccountQueryResultSchema::class),
                ),
            ),
        ],
    )]
    public function __invoke(MessengerAccountQuery $query): Response
    {
        return JsonResponse::fromJsonString(
            $this->serializer->serialize(
                $this->queryBus->execute($query),
                JsonEncoder::FORMAT,
                [SerializationContextParam::isHttpResponse->value => true],
            ),
            Response::HTTP_OK,
        );
    }
}

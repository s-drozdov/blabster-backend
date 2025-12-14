<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Http\Controller;

use OpenApi\Attributes as OA;
use Blabster\Library\Enum\PhpType;
use Blabster\Infrastructure\Enum\Action;
use Blabster\Infrastructure\Enum\OpenApiTag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Blabster\Infrastructure\Enum\OpenApiSummary;
use Symfony\Component\HttpFoundation\JsonResponse;
use Blabster\Infrastructure\Enum\OpenApiOperationId;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Blabster\Infrastructure\Enum\OpenApiSchemaDescription;

#[AsController]
#[Route(Action::health_check->value, name: Action::health_check->name, methods: [Request::METHOD_GET])]
final readonly class HealthCheckAction
{
    #[OA\Get(
        path: Action::health_check->value,
        operationId: OpenApiOperationId::HealthCheck->value,
        summary: OpenApiSummary::HealthCheck->value,
        tags: [OpenApiTag::Status->value],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: OpenApiSchemaDescription::status->value,
                content: new OA\JsonContent(
                    type: PhpType::object->value,
                    properties: [
                        new OA\Property(
                            property: 'status',
                            type: PhpType::string->value,
                            example: 'ok',
                        ),
                    ],
                ),
            ),
        ],
    )]
    public function __invoke(): Response
    {
        return new JsonResponse(['status' => 'ok']);
    }
}

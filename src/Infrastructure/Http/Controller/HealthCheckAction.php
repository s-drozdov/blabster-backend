<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Http\Controller;

use OpenApi\Attributes as OA;
use Blabster\Library\Enum\PhpType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
#[Route('/health-check', name: 'health_check', methods: [Request::METHOD_GET])]
final readonly class HealthCheckAction
{
    #[OA\Get(
        path: '/registry/health-check',
        operationId: 'getHealthCheck',
        summary: 'Get health check',
        tags: ['registry'],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'status',
                content: new OA\JsonContent(
                type: PhpType::object->value,
                properties: [
                    new OA\Property(
                        property: 'status',
                        type: PhpType::string->value,
                        example: 'ok'
                    )
                ]
            )
            )
        ]
    )]
    public function __invoke(): Response
    {
        return new JsonResponse(['status' => 'ok']);
    }
}

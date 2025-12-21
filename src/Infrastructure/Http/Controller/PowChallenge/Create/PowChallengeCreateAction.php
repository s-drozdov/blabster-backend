<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Http\Controller\PowChallenge\Create;

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
use Blabster\Application\UseCase\Command\PowChallenge\Create\PowChallengeCreateCommand;
use Blabster\Application\UseCase\Command\PowChallenge\Create\PowChallengeCreateCommandResult;
use Blabster\Infrastructure\OpenApi\Schema\UseCase\Command\PowChallenge\Create\PowChallengeCreateCommandResult as PowChallengeCreateCommandResultSchema;

#[AsController]
#[Route(Action::pow_challenge_create->value, name: Action::pow_challenge_create->name, methods: [Request::METHOD_POST])]
final class PowChallengeCreateAction
{
    public function __construct(

        /** @var CommandBusInterface<PowChallengeCreateCommand,PowChallengeCreateCommandResult> */
        private CommandBusInterface $commandBus,

        private SerializerInterface $serializer,
    ) {
        /*_*/
    }

    #[OA\Post(
        path: Action::pow_challenge_create->value,
        operationId: OpenApiOperationId::PowChallengeCreate->value,
        summary: OpenApiSummary::PowChallengeCreate->value,
        tags: [OpenApiTag::PowChallenge->value],
        responses: [
            new OA\Response(
                response: Response::HTTP_CREATED,
                description: OpenApiSchemaDescription::PowChallengeCreateCommandResult->value,
                content: new OA\JsonContent(
                    ref: new Model(type: PowChallengeCreateCommandResultSchema::class),
                ),
            ),
        ],
    )]
    public function __invoke(PowChallengeCreateCommand $command): Response
    {
        return JsonResponse::fromJsonString(
            $this->serializer->serialize(
                $this->commandBus->execute($command),
                JsonEncoder::FORMAT,
                [SerializationContextParam::isHttpResponse->value => true],
            ),
            Response::HTTP_CREATED,
        );
    }
}

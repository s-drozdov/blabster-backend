<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Http\Controller\PowChallenge;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Blabster\Infrastructure\Bus\CommandBusInterface;
use Blabster\Library\Enum\SerializationContextParam;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Blabster\Application\UseCase\Command\PowChallenge\Create\PowChallengeCreateCommand;
use Blabster\Application\UseCase\Command\PowChallenge\Create\PowChallengeCreateCommandResult;

#[AsController]
#[Route('/pow-challenge', name: 'pow_challenge_create', methods: [Request::METHOD_POST])]
final class PowChallengeCreateAction
{
    public function __construct(

        /** @var CommandBusInterface<PowChallengeCreateCommand,PowChallengeCreateCommandResult> */
        private CommandBusInterface $commandBus,

        private SerializerInterface $serializer,
    ){
        /*_*/
    }

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

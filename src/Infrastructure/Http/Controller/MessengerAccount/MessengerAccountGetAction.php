<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Http\Controller\MessengerAccount;

use Blabster\Infrastructure\Enum\Action;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Blabster\Application\Bus\QueryBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Blabster\Library\Enum\SerializationContextParam;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Blabster\Application\UseCase\Query\MessengerAccount\MessengerAccountQuery;
use Blabster\Application\UseCase\Query\MessengerAccount\MessengerAccountQueryResult;

#[AsController]
#[Route(Action::otp_create->value, name: Action::otp_create->name, methods: [Request::METHOD_POST])]
final class MessengerAccountGetAction
{
    public function __construct(

        /** @var QueryBusInterface<MessengerAccountQuery,MessengerAccountQueryResult> */
        private QueryBusInterface $queryBus,

        private SerializerInterface $serializer,
    ){
        /*_*/
    }

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

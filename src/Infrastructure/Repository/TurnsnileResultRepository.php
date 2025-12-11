<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Repository;

use Override;
use Blabster\Domain\Entity\TurnsnileResult;
use Blabster\Library\SDK\Turnsnile\TurnsnileSdk;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Blabster\Domain\Repository\TurnsnileResultRepositoryInterface;

final class TurnsnileResultRepository implements TurnsnileResultRepositoryInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private TurnsnileSdk $turnsnileSdk,
    ) {
        /*_*/
    }
    
    #[Override]
    public function get(string $turnsnileToken, ?string $clientRemoteIp = null): TurnsnileResult
    {
        $response = $this->turnsnileSdk->getResult($turnsnileToken, $clientRemoteIp);
        
        return $this->serializer->deserialize(
            (string) $response->getBody(),
            TurnsnileResult::class,
            JsonEncoder::FORMAT,
        );
    }
}

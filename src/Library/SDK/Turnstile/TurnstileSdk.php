<?php

declare(strict_types=1);

namespace Blabster\Library\SDK\Turnstile;

use Override;
use Webmozart\Assert\Assert;
use Psr\Http\Client\ClientInterface;
use Blabster\Library\SDK\SdkInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Blabster\Library\SDK\Turnstile\Response\TurnstileResultDto;

final class TurnstileSdk implements TurnstileSdkInterface
{
    public function __construct(
        private ClientInterface $client,
        private RequestFactoryInterface $requestFactory,
        private StreamFactoryInterface $streamFactory,
        private SerializerInterface $serializer,
        private string $apiUrl,
        private string $apiSecret,
    ) {
        /*_*/
    }
    
    #[Override]
    public function getResult(string $turnsnileToken, ?string $clientRemoteIp = null): TurnstileResultDto
    {
        $response = $this->client->sendRequest(
            $this->getRequest($turnsnileToken, $clientRemoteIp),
        );

        Assert::eq($response->getStatusCode(), Response::HTTP_OK, SdkInterface::ERROR_BAD_RESPONSE);
        
        return $this->serializer->deserialize(
            (string) $response->getBody(),
            TurnstileResultDto::class,
            JsonEncoder::FORMAT,
        );
    }

    private function getRequest(string $response, ?string $remoteip = null): RequestInterface
    {
        $payload = [
            'secret'   => $this->apiSecret,
            'response' => $response,
        ];

        if ($remoteip !== null) {
            $payload['remoteip'] = $remoteip;
        }

        $body = http_build_query($payload);
        
        return $this->requestFactory
            ->createRequest(Request::METHOD_POST, $this->apiUrl)
            ->withHeader(SdkInterface::HEADER_CONTENT_TYPE, SdkInterface::CONTENT_TYPE_FORM_URL_ENCODED)
            ->withBody(
                $this->streamFactory->createStream($body),
            );
    }
}

<?php

declare(strict_types=1);

namespace Blabster\Library\SDK\Turnsnile;

use Webmozart\Assert\Assert;
use InvalidArgumentException;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class TurnsnileSdk implements SdkInterface
{
    public function __construct(
        private ClientInterface $client,
        private RequestFactoryInterface $requestFactory,
        private StreamFactoryInterface $streamFactory,
        private string $apiUrl,
        private string $apiSecret,
    ) {
        /*_*/
    }
    
    /**
     * @throws InvalidArgumentException
     */
    public function getResult(string $turnsnileToken, ?string $clientRemoteIp = null): ResponseInterface
    {
        $response = $this->client->sendRequest(
            $this->getRequest($turnsnileToken, $clientRemoteIp),
        );

        Assert::eq($response->getStatusCode(), Response::HTTP_OK, SdkInterface::ERROR_BAD_RESPONSE);
        
        return $response;
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
            ->withHeader(SdkInterface::HEADER_CONTENT_TYPE, SdkInterface::FORM_URL_ENCODED)
            ->withBody(
                $this->streamFactory->createStream($body),
            );
    }
}

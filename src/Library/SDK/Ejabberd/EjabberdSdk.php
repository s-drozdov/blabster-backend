<?php

declare(strict_types=1);

namespace Blabster\Library\SDK\Ejabberd;

use Override;
use Webmozart\Assert\Assert;
use Psr\Http\Client\ClientInterface;
use Blabster\Library\SDK\SdkInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Blabster\Library\SDK\SdkRequestDtoInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Blabster\Library\SDK\Ejabberd\Enum\EjabberdEndpoint;
use Blabster\Library\SDK\Ejabberd\Request\RegisterRequestDto;
use Blabster\Library\SDK\Ejabberd\Request\CheckAccountRequestDto;
use Blabster\Library\SDK\Ejabberd\Request\AddRosterItemRequestDto;
use Blabster\Library\SDK\Ejabberd\Response\CheckAccountResponseDto;

final class EjabberdSdk implements EjabberdSdkInterface
{
    public function __construct(
        private ClientInterface $client,
        private RequestFactoryInterface $requestFactory,
        private StreamFactoryInterface $streamFactory,
        private SerializerInterface $serializer,
        private string $apiUrl,
        private string $apiBasicLogin,
        private string $apiBasicPassword,
    ) {
        /*_*/
    }
    
    #[Override]
    public function addRosterItem(AddRosterItemRequestDto $requestDto): void
    {
        $response = $this->client->sendRequest(
            $this->getRequest($requestDto, EjabberdEndpoint::add_rosteritem->value),
        );

        Assert::eq($response->getStatusCode(), Response::HTTP_OK, SdkInterface::ERROR_BAD_RESPONSE);
    }
    
    #[Override]
    public function checkAccount(CheckAccountRequestDto $requestDto): CheckAccountResponseDto
    {
        $response = $this->client->sendRequest(
            $this->getRequest($requestDto, EjabberdEndpoint::check_account->value),
        );

        Assert::eq($response->getStatusCode(), Response::HTTP_OK, SdkInterface::ERROR_BAD_RESPONSE);

        $isError = (bool) (string) $response->getBody();

        return new CheckAccountResponseDto(
            is_user_exist: !$isError,
        );
    }
    
    #[Override]
    public function register(RegisterRequestDto $requestDto): void
    {
        $response = $this->client->sendRequest(
            $this->getRequest($requestDto, EjabberdEndpoint::register->value),
        );

        Assert::eq($response->getStatusCode(), Response::HTTP_OK, SdkInterface::ERROR_BAD_RESPONSE);
    }

    private function getRequest(SdkRequestDtoInterface $sdkRequestDto, string $endpoint): RequestInterface 
    {
        $auth = base64_encode(
            sprintf('%s:%s', $this->apiBasicLogin, $this->apiBasicPassword),
        );

        return $this->requestFactory
            ->createRequest(Request::METHOD_POST, $this->apiUrl . $endpoint)
            ->withHeader(self::HEADER_CONTENT_TYPE, self::CONTENT_TYPE_JSON)
            ->withHeader(
                self::HEADER_AUTHORIZATION,
                sprintf('%s %s', self::AUTHORIZATION_BASIC, $auth),
            )
            ->withBody(
                $this->streamFactory->createStream(
                    $this->serializer->serialize($sdkRequestDto, JsonEncoder::FORMAT),
                ),
            );
    }
}

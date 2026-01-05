<?php

namespace Blabster\Tests\Functional\Api\Otp;

use Blabster\Infrastructure\Enum\Resource;
use Symfony\Component\HttpFoundation\Request;
use Blabster\Tests\Functional\Api\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

final class OtpApiTest extends ApiTestCase
{
    public function testCreateOtpIsPublic(): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_POST, Resource::Otp->value);
        
        $this->assertNotSame($client->getResponse()->getStatusCode(), Response::HTTP_UNAUTHORIZED);
    }
}

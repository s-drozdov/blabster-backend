<?php

namespace Blabster\Tests\Functional\Api\MessengerAccount;

use Blabster\Infrastructure\Enum\Resource;
use Symfony\Component\HttpFoundation\Request;
use Blabster\Tests\Functional\Api\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

final class MessengerAccountApiTest extends ApiTestCase
{
    public function testGetMessengerAccountIsPrivate(): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, Resource::MessengerAccount->value);
        
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }
}

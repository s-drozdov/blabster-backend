<?php

namespace Blabster\Tests\Functional\Api\User;

use Blabster\Infrastructure\Enum\Resource;
use Symfony\Component\HttpFoundation\Request;
use Blabster\Tests\Functional\Api\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

final class UserApiTest extends ApiTestCase
{
    public function testLoginIsPublic(): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_POST, Resource::Login->value);
        
        $this->assertNotSame($client->getResponse()->getStatusCode(), Response::HTTP_UNAUTHORIZED);
    }

    public function testRefreshIsPublic(): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_POST, Resource::Refresh->value);
        
        $this->assertNotSame($client->getResponse()->getStatusCode(), Response::HTTP_UNAUTHORIZED);
    }

    public function testLogoutIsPrivate(): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_POST, Resource::Logout->value);
        
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testLogoutAllIsPrivate(): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_POST, Resource::LogoutAll->value);
        
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }
}

<?php

namespace Blabster\Tests\Functional\Api\HealthCheck;

use Blabster\Infrastructure\Enum\Resource;
use Symfony\Component\HttpFoundation\Request;
use Blabster\Tests\Functional\Api\ApiTestCase;

final class HealthCheckApiTest extends ApiTestCase
{
    public function testGetHealthCheckIsPublic(): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, Resource::HealthCheck->value);
        
        $this->assertResponseIsSuccessful();
    }
}

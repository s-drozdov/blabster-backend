<?php

namespace Blabster\Tests\Functional\Api\PowChallenge;

use Blabster\Infrastructure\Enum\Resource;
use Symfony\Component\HttpFoundation\Request;
use Blabster\Tests\Functional\Api\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

final class PowChallengeApiTest extends ApiTestCase
{
    public function testCreatePowChallengeIsPublic(): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_POST, Resource::PowChallenge->value);
        
        $this->assertNotSame($client->getResponse()->getStatusCode(), Response::HTTP_UNAUTHORIZED);
    }
}

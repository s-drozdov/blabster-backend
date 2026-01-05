<?php

declare(strict_types=1);

namespace Blabster\Tests\Functional\Api;

use DAMA\DoctrineTestBundle\Doctrine\DBAL\StaticDriver;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class ApiTestCase extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        StaticDriver::beginTransaction();
    }
    
    protected function tearDown(): void
    {
        parent::tearDown();
        
        StaticDriver::rollBack();
    }
}

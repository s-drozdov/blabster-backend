<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Domain\Factory;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\Attributes\Before;
use Blabster\Domain\ValueObject\UuidInterface;
use Blabster\Domain\Helper\Uuid\UuidHelperInterface;
use Blabster\Infrastructure\Helper\Uuid\RamseyUuidHelper;

abstract class AbstractFactoryTestCase extends TestCase
{
    protected const string UUID_STRING = '123e4567-e89b-12d3-a456-426614174000';

    protected UuidInterface $uuid;
    protected UuidHelperInterface $uuidHelper;

    /** @var UuidHelperInterface|Stub */
    protected UuidHelperInterface $uuidHelperStub;
    
    #[Before]
    public function before(): void
    {
        $this->uuidHelper = new RamseyUuidHelper();
        $this->uuid = $this->uuidHelper->fromString(self::UUID_STRING);

        $this->uuidHelperStub = $this->createStub(UuidHelperInterface::class);
        $this->uuidHelperStub->method('create')->willReturn($this->uuid);
    }
}
<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Application\Dto\Mapper;

use LogicException;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Domain\Entity\PowChallenge;
use Blabster\Application\Dto\PowChallengeDto;
use Blabster\Domain\ValueObject\UuidInterface;
use Blabster\Application\Dto\Mapper\PowChallengeMapper;

final class PowChallengeMapperTest extends TestCase
{
    private const string PREFIX = 'prefix';
    private const string SALT = 'salt';
    private const int DIFFICULTY = 4;

    #[Test]
    public function testMapDomainObjectToDto(): void
    {
        // arrange
        $uuid = $this->createStub(UuidInterface::class);
        $expiresAt = new DateTimeImmutable();

        $powChallenge = $this->createStub(PowChallenge::class);
        $powChallenge->method('getUuid')->willReturn($uuid);
        $powChallenge->method('getPrefix')->willReturn(self::PREFIX);
        $powChallenge->method('getSalt')->willReturn(self::SALT);
        $powChallenge->method('getDifficulty')->willReturn(self::DIFFICULTY);
        $powChallenge->method('getExpiresAt')->willReturn($expiresAt);

        $mapper = new PowChallengeMapper();

        // act
        $dto = $mapper->mapDomainObjectToDto($powChallenge);

        // assert
        self::assertInstanceOf(PowChallengeDto::class, $dto);
        self::assertSame($uuid, $dto->uuid);
        self::assertSame(self::PREFIX, $dto->prefix);
        self::assertSame(self::SALT, $dto->salt);
        self::assertSame(self::DIFFICULTY, $dto->difficulty);
        self::assertSame($expiresAt, $dto->expires_at);
    }

    #[Test]
    public function testMapDtoToDomainObjectThrowsException(): void
    {
        // arrange
        $mapper = new PowChallengeMapper();
        $powChallengeDto = $this->createStub(PowChallengeDto::class);

        $this->expectException(LogicException::class);

        // act
        $mapper->mapDtoToDomainObject($powChallengeDto);
    }

    #[Test]
    public function testGetEntityType(): void
    {        
        // arrange
        $mapper = new PowChallengeMapper();

        // act
        $entityType = $mapper->getEntityType();

        // assert
        self::assertSame(PowChallenge::class, $entityType);
    }

    #[Test]
    public function testGetDtoType(): void
    {
        // arrange
        $mapper = new PowChallengeMapper();

        // act
        $dto = $mapper->getDtoType();

        // assert
        self::assertSame(PowChallengeDto::class, $dto);
    }
}

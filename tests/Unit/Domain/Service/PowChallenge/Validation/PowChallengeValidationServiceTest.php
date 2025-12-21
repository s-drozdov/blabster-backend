<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Domain\Service\PowChallenge\Validation;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Domain\Entity\PowChallenge;
use Blabster\Domain\ValueObject\UuidInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use Blabster\Domain\Repository\PowChallengeRepositoryInterface;
use Blabster\Domain\Service\PowChallenge\Validation\PowChallengeValidationService;

final class PowChallengeValidationServiceTest extends TestCase
{
    private const int DIFFICULTY = 3;
    private const string PREFIX = 'prefix';
    private const string SALT = 'salt';
    private const string INVALID_NONCE = 'invalid-nonce';

    #[Test]
    #[DataProvider('getValidationSuccessDataProvider')]
    public function testValidationSuccess(int $difficulty, string $prefix, string $salt): void
    {
        // arrange
        $nonce = $this->findValidNonce($prefix, $salt, $difficulty);

        $powChallenge = $this->createStub(PowChallenge::class);
        $powChallenge->method('getDifficulty')->willReturn($difficulty);
        $powChallenge->method('getPrefix')->willReturn($prefix);
        $powChallenge->method('getSalt')->willReturn($salt);

        $uuid = $this->createStub(UuidInterface::class);

        $repository = $this->createStub(PowChallengeRepositoryInterface::class);
        $repository->method('getByUuid')->with($uuid)->willReturn($powChallenge);

        $service = new PowChallengeValidationService($repository);

        // act
        $service->perform($uuid, $nonce);

        // assert
        self::assertTrue(true);
    }
    
    public static function getValidationSuccessDataProvider()
    {
        return [
            [2, 'ab', 'cd'],
            [4, 'asdfgasfdgahhbnvnf', 'fgnbnnmjhhl'],
        ];
    }

    #[Test]
    public function testValidationFailsWhenHashDoesNotMatch(): void
    {
        // arrange
        $powChallenge = $this->createStub(PowChallenge::class);
        $powChallenge->method('getDifficulty')->willReturn(self::DIFFICULTY);
        $powChallenge->method('getPrefix')->willReturn(self::PREFIX);
        $powChallenge->method('getSalt')->willReturn(self::SALT);

        $uuid = $this->createStub(UuidInterface::class);

        $repository = $this->createStub(PowChallengeRepositoryInterface::class);
        $repository->method('getByUuid')->willReturn($powChallenge);

        $service = new PowChallengeValidationService($repository);

        $this->expectException(InvalidArgumentException::class);

        // act
        $service->perform($uuid, self::INVALID_NONCE);
    }
    
    private function findValidNonce(string $prefix, string $salt, int $difficulty): string
    {
        $target = str_repeat('0', $difficulty);

        for ($i = 0; $i < 100_000; $i++) {
            $nonce = (string) $i;
            $hash = hash('sha256', $prefix . $salt . $nonce);

            if (str_starts_with($hash, $target)) {
                return $nonce;
            }
        }

        self::fail('Cannot calculate test nonce');
    }
}

<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Domain\Service\Fingerprint\Match;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Domain\Entity\Fingerprint;
use Blabster\Domain\Factory\FingerprintFactoryInterface;
use Blabster\Domain\Repository\FingerprintRepositoryInterface;
use Blabster\Domain\Service\Fingerprint\Match\FingerprintMatchService;

final class FingerprintMatchServiceTest extends TestCase
{
    private const string EXISTING_FINGERPRINT_VALUE = 'existing-fingerprint';
    private const string NEW_FINGERPRINT_VALUE = 'new-fingerprint';

    #[Test]
    public function testPerformReturnsExistingFingerprint(): void
    {
        // arrange
        $existingFingerprint = $this->createStub(Fingerprint::class);

        $repository = $this->createMock(FingerprintRepositoryInterface::class);

        $repository
            ->expects(self::once())
            ->method('findByValue')
            ->with(self::EXISTING_FINGERPRINT_VALUE)
            ->willReturn($existingFingerprint)
        ;

        $repository->expects(self::never())->method('save');

        $service = new FingerprintMatchService(
            $repository, 
            $this->createStub(FingerprintFactoryInterface::class),
        );

        // act
        $result = $service->perform(self::EXISTING_FINGERPRINT_VALUE);

        // assert
        self::assertSame($existingFingerprint, $result);
    }

    #[Test]
    public function testPerformCreatesAndSavesFingerprintWhenNotFound(): void
    {
        // arrange
        $newFingerprint = $this->createStub(Fingerprint::class);

        $repository = $this->createMock(FingerprintRepositoryInterface::class);
        
        $repository
            ->expects(self::once())
            ->method('findByValue')
            ->with(self::NEW_FINGERPRINT_VALUE)
            ->willReturn(null)
        ;

        $repository->expects(self::once())->method('save')->with($newFingerprint);

        $factory = $this->createMock(FingerprintFactoryInterface::class);

        $factory
            ->expects(self::once())
            ->method('create')
            ->with(self::NEW_FINGERPRINT_VALUE)
            ->willReturn($newFingerprint)
        ;

        $service = new FingerprintMatchService($repository, $factory);

        // act
        $result = $service->perform(self::NEW_FINGERPRINT_VALUE);

        // assert
        self::assertNull($result);
    }
}

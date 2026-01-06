<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Domain\Service\PowChallenge\Create;

use PHPUnit\Framework\TestCase;
use Blabster\Domain\Entity\PowChallenge;
use Blabster\Domain\Factory\PowChallengeFactoryInterface;
use Blabster\Domain\Repository\PowChallengeRepositoryInterface;
use Blabster\Domain\Service\PowChallenge\Create\PowChallengeCreateService;

final class PowChallengeCreateServiceTest extends TestCase
{
    private const int DIFFICULTY = 4;

    public function testPerformCreatesAndSavesPowChallenge(): void
    {
        // arrange
        $powChallenge = $this->createStub(PowChallenge::class);

        $factory = $this->createMock(PowChallengeFactoryInterface::class);

        $factory
            ->expects(self::once())
            ->method('create')
            ->with(self::DIFFICULTY)
            ->willReturn($powChallenge)
        ;

        $repository = $this->createMock(PowChallengeRepositoryInterface::class);
        $repository->expects(self::once())->method('save')->with($powChallenge);

        $service = new PowChallengeCreateService($factory, $repository, self::DIFFICULTY);

        // act
        $result = $service->perform();

        // assert
        self::assertSame($powChallenge, $result);
    }
}

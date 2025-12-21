<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Application\UseCase\Command\PowChallenge\Create;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Domain\Entity\PowChallenge;
use Blabster\Application\Dto\PowChallengeDto;
use Blabster\Application\Bus\CqrsElementInterface;
use Blabster\Application\Dto\Mapper\PowChallengeMapper;
use Blabster\Domain\Service\PowChallenge\Create\PowChallengeCreateServiceInterface;
use Blabster\Application\UseCase\Command\PowChallenge\Create\PowChallengeCreateCommandResult;
use Blabster\Application\UseCase\Command\PowChallenge\Create\PowChallengeCreateCommandHandler;

final class PowChallengeCreateCommandHandlerTest extends TestCase
{
    #[Test]
    public function testHandle(): void
    {
        // arrange
        $command = $this->createStub(CqrsElementInterface::class);

        $powChallenge = $this->createStub(PowChallenge::class);
        $powChallengeDto = $this->createStub(PowChallengeDto::class);

        $createService = $this->createMock(PowChallengeCreateServiceInterface::class);

        $createService
            ->expects(self::once())
            ->method('perform')
            ->willReturn($powChallenge)
        ;

        $mapper = $this->createMock(PowChallengeMapper::class);

        $mapper
            ->expects(self::once())
            ->method('mapDomainObjectToDto')
            ->with($powChallenge)
            ->willReturn($powChallengeDto)
        ;

        $handler = new PowChallengeCreateCommandHandler($createService, $mapper);

        // act
        $result = $handler($command);

        // assert
        self::assertInstanceOf(PowChallengeCreateCommandResult::class, $result);
        self::assertSame($powChallengeDto, $result->pow_challenge);
    }
}

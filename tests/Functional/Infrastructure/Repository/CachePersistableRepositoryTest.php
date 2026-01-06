<?php

declare(strict_types=1);

namespace Blabster\Tests\Functional\Infrastructure\Repository;

use Blabster\Domain\Factory\PowChallengeFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Blabster\Domain\Repository\PowChallengeRepositoryInterface;
use PHPUnit\Framework\Attributes\Test;

final class CachePersistableRepositoryTest extends KernelTestCase
{
    private const int DIFFICULTY = 4;

    private PowChallengeFactoryInterface $powChallengeFactory;
    private PowChallengeRepositoryInterface $powChallengeRepository;

    public function setUp(): void
    {
        parent::setUp();

        self::bootKernel();
        $container = static::getContainer();
        
        $this->powChallengeFactory = $container->get(PowChallengeFactoryInterface::class);
        $this->powChallengeRepository = $container->get(PowChallengeRepositoryInterface::class);
    }

    #[Test]
    public function testPersistance(): void
    {
        $powChallenge = $this->powChallengeFactory->create(self::DIFFICULTY);
        $this->powChallengeRepository->save($powChallenge);

        $this->powChallengeRepository->getByUuid($powChallenge->getUuid());
        $this->assertTrue(true); // test does not throw
    }
}

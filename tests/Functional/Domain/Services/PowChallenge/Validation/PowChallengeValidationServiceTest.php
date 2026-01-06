<?php

declare(strict_types=1);

namespace Blabster\Tests\Functional\Domain\Services\PowChallenge\Validation;

use PHPUnit\Framework\Attributes\Test;
use Blabster\Domain\Entity\PowChallenge;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Blabster\Domain\Service\PowChallenge\Create\PowChallengeCreateServiceInterface;
use Blabster\Domain\Service\PowChallenge\Validation\PowChallengeValidationServiceInterface;

final class PowChallengeValidationServiceTest extends KernelTestCase
{
    private const string ALGORYTHM = 'sha256';

    private PowChallengeCreateServiceInterface $powChallengeCreateService;
    private PowChallengeValidationServiceInterface $powChallengeValidationService;

    public function setUp(): void
    {
        parent::setUp();

        self::bootKernel();
        $container = static::getContainer();
        
        $this->powChallengeCreateService = $container->get(PowChallengeCreateServiceInterface::class);
        $this->powChallengeValidationService = $container->get(PowChallengeValidationServiceInterface::class);
    }

    #[Test]
    public function testAlgorythm(): void
    {
        $powChallenge = $this->powChallengeCreateService->perform();

        $this->powChallengeValidationService->perform(
            $powChallenge->getUuid(),
            $this->solvePow($powChallenge),
        );

        $this->assertTrue(true); // test does not throws
    }

    private function solvePow(PowChallenge $powChallenge): string
    {
        $target = str_repeat('0', $powChallenge->getDifficulty());
        $nonce = 0;
        
        while (true) {
            $input = sprintf('%s%s%s', $powChallenge->getPrefix(), $powChallenge->getSalt(), $nonce);
            $hash = hash(self::ALGORYTHM, $input);
            
            if (str_starts_with($hash, $target)) {
                return sprintf('%d', $nonce);
            }
            
            $nonce++;
        }
    }
}

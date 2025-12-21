<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\Fingerprint\Match;

use Override;
use Blabster\Domain\Entity\Fingerprint;
use Blabster\Domain\Factory\FingerprintFactoryInterface;
use Blabster\Domain\Repository\FingerprintRepositoryInterface;

final readonly class FingerprintMatchService implements FingerprintMatchServiceInterface
{
    public function __construct(
        private FingerprintRepositoryInterface $fingerprintRepository,
        private FingerprintFactoryInterface $fingerprintFactory,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(string $value): ?Fingerprint
    {
        $result = $this->fingerprintRepository->findByValue($value);

        if ($result === null) {
            $this->fingerprintRepository->save(
                $this->fingerprintFactory->create($value),
            );
        }

        return $result;
    }
}

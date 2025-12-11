<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\Fingerprint\Match;

use InvalidArgumentException;
use Blabster\Domain\Entity\Fingerprint;
use Blabster\Domain\Factory\FingerprintFactory;
use Blabster\Domain\Service\ServiceInterface;
use Blabster\Domain\Repository\FingerprintRepositoryInterface;

final readonly class FingerprintMatchService implements ServiceInterface
{
    public function __construct(
        private FingerprintRepositoryInterface $fingerprintRepository,
        private FingerprintFactory $fingerprintFactory,
    ) {
        /*_*/
    }

    /**
     * @throws InvalidArgumentException
     */
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

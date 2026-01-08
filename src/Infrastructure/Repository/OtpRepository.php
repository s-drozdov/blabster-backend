<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Repository;

use Override;
use Blabster\Domain\Entity\Otp;
use Psr\SimpleCache\CacheInterface;
use Blabster\Domain\ValueObject\UuidInterface;
use Blabster\Domain\Repository\OtpRepositoryInterface;
use Blabster\Domain\Helper\String\StringHelperInterface;

final class OtpRepository implements OtpRepositoryInterface
{
    private const string ERROR_NOT_FOUND_MESSAGE = 'Error. OTP is expired.';

    /** @use CachePersistable<Otp> */
    use CachePersistable;

    public function __construct(
        private CacheInterface $cache,
        private StringHelperInterface $stringHelper,
        private int|null $ttlSeconds,
    ) {
        /*_*/
    }

    #[Override]
    private function getCache(): CacheInterface
    {
        return $this->cache;
    }

    #[Override]
    private function getTtl(): ?int
    {
        return $this->ttlSeconds;
    }

    #[Override]
    private function getStringHelper(): StringHelperInterface
    {
        return $this->stringHelper;
    }

    #[Override]
    private function getEntityFqcn(): string
    {
        return Otp::class;
    }

    private function getNotFoundErrorMessage(UuidInterface $uuid): string
    {
        return self::ERROR_NOT_FOUND_MESSAGE;
    }
}

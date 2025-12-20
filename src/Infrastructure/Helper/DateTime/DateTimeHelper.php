<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Helper\DateTime;

use Override;
use DateInterval;
use DateTimeImmutable;
use Webmozart\Assert\Assert;
use Blabster\Domain\Helper\DateTime\DateTimeHelperInterface;

final readonly class DateTimeHelper implements DateTimeHelperInterface
{
    #[Override]
    public function getExpiresAt(?int $ttlSeconds): ?DateTimeImmutable
    {
        if ($ttlSeconds === null) {
            return null;
        }

        $interval = DateInterval::createFromDateString(
            sprintf('%s seconds', $ttlSeconds),
        );

        Assert::notFalse($interval);

        return new DateTimeImmutable()->add($interval);
    }
}

<?php

declare(strict_types=1);

namespace Blabster\Library\Helper\DateTime;

use DateInterval;
use DateTimeImmutable;
use Override;
use Webmozart\Assert\Assert;

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

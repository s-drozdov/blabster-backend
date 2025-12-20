<?php

declare(strict_types=1);

namespace Blabster\Domain\Helper\DateTime;

use DateTimeImmutable;
use InvalidArgumentException;
use Blabster\Domain\Helper\HelperInterface;

interface DateTimeHelperInterface extends HelperInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function getExpiresAt(?int $ttlSeconds): ?DateTimeImmutable;
}

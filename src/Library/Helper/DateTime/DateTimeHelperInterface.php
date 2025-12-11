<?php

declare(strict_types=1);

namespace Blabster\Library\Helper\DateTime;

use DateTimeImmutable;
use InvalidArgumentException;
use Blabster\Library\Helper\HelperInterface;

interface DateTimeHelperInterface extends HelperInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function getExpiresAt(?int $ttlSeconds): ?DateTimeImmutable;
}

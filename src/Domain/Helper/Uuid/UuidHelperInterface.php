<?php

declare(strict_types=1);

namespace Blabster\Domain\Helper\Uuid;

use Blabster\Domain\Helper\HelperInterface;
use Blabster\Domain\ValueObject\UuidInterface;

interface UuidHelperInterface extends HelperInterface
{
    public function create(): UuidInterface;

    public function fromString(string $source): UuidInterface;

    public function fromBytes(string $source): UuidInterface;

    public function isValid(string $uuid): bool;
}

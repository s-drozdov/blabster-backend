<?php

declare(strict_types=1);

namespace Blabster\Domain\Entity;

use Blabster\Domain\DomainObjectInterface;
use Blabster\Domain\ValueObject\UuidInterface;

interface EntityInterface extends DomainObjectInterface
{
    public function getUuid(): UuidInterface; 
}

<?php

declare(strict_types=1);

namespace Blabster\Domain\Entity;

use Blabster\Domain\DomainObjectInterface;

interface EntityInterface extends DomainObjectInterface
{
    public function getId(): int; 
}

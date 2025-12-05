<?php

declare(strict_types=1);

namespace Blabster\Domain\Entity;

use Override;

final class User implements EntityInterface
{
    public function __construct(
        private int $id,
        private string $email,
        private string $created_at,
    ) {
        /*_*/
    }

    #[Override]
    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
<?php

declare(strict_types=1);

namespace Blabster\Domain\Entity\User;

use Override;
use DateTimeImmutable;
use Blabster\Domain\Enum\Role;
use Blabster\Domain\Entity\Eventable;
use Doctrine\Common\Collections\Collection;
use Blabster\Domain\Entity\User\RefreshToken;
use Blabster\Domain\Entity\AggregateInterface;
use Blabster\Domain\ValueObject\UuidInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Blabster\Domain\Entity\User\MessengerAccount;
use Symfony\Component\Security\Core\User\UserInterface;

final class User implements UserInterface, AggregateInterface
{
    use Eventable;

    /** @var Collection<array-key,RefreshToken> $refreshTokenList */ 
    private Collection $refreshTokenList;

    public function __construct(
        private UuidInterface $uuid,

        /** @var non-empty-string $email */
        private string $email,
        
        private ?MessengerAccount $messenger_account,
        private DateTimeImmutable $created_at,
    ) {
        $this->refreshTokenList = new ArrayCollection();
    }
 
    #[Override]
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return Collection<array-key,RefreshToken>
     */
    public function getRefreshTokenList(): Collection
    {
        return $this->refreshTokenList;
    }

    public function getMessengerAccount(): ?MessengerAccount
    {
        return $this->messenger_account;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->created_at;
    }

    #[Override]
    public function getRoles(): array
    {
        return [Role::User->value];
    }

    /** @deprecated */
    #[Override]
    public function eraseCredentials(): void
    {}

    #[Override]
    public function getUserIdentifier(): string
    {
        return $this->email;
    }
}

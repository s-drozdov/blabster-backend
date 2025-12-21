<?php

declare(strict_types=1);

namespace Blabster\Domain\Factory\User;

use Override;
use DateTimeImmutable;
use Webmozart\Assert\Assert;
use Blabster\Domain\Entity\User\User;
use Blabster\Domain\Event\User\UserCreated;
use Blabster\Domain\Helper\Uuid\UuidHelperInterface;

final readonly class UserFactory implements UserFactoryInterface
{
    public function __construct(
        private UuidHelperInterface $uuidHelper,
    ) {
        /*_*/
    }

    #[Override]
    public function create(string $email): User
    {
        Assert::notEmpty($email);

        $user = new User(
            uuid: $this->uuidHelper->create(),
            email: $email,
            created_at: new DateTimeImmutable(),
        );

        $user->raise(
            new UserCreated(
                uuid: $user->getUuid(),
            ),
        );

        return $user;
    }
}

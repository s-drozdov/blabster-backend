<?php

declare(strict_types=1);

namespace Blabster\Domain\Factory;

use DateTimeImmutable;
use Webmozart\Assert\Assert;
use Blabster\Domain\Entity\User\User;
use Blabster\Library\Helper\Uuid\UuidHelperInterface;

final readonly class UserFactory implements FactoryInterface
{
    public function __construct(
        private UuidHelperInterface $uuidHelper,
    ) {
        /*_*/
    }

    public function create(string $email): User
    {
        Assert::notEmpty($email);

        return new User(
            uuid: $this->uuidHelper->create(),
            email: $email,
            messenger_account: null,
            created_at: new DateTimeImmutable(),
        );
    }
}

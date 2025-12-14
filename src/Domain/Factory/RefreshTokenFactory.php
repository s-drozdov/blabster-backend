<?php

declare(strict_types=1);

namespace Blabster\Domain\Factory;

use DateTimeImmutable;
use Webmozart\Assert\Assert;
use Blabster\Domain\Entity\User\User;
use Blabster\Domain\Entity\User\RefreshToken;
use Blabster\Library\Helper\Uuid\UuidHelperInterface;
use DateInterval;

final readonly class RefreshTokenFactory implements FactoryInterface
{
    public function __construct(
        private UuidHelperInterface $uuidHelper,
        private string $expirationPeriod,
    ) {
        /*_*/
    }

    public function create(User $user, string $tokenValue): RefreshToken
    {
        Assert::notEmpty($tokenValue);

        return new RefreshToken(
            uuid: $this->uuidHelper->create(),
            user: $user,
            value: $tokenValue,
            expires_at: new DateTimeImmutable()
                ->add(
                    new DateInterval($this->expirationPeriod),
                ),
        );
    }
}

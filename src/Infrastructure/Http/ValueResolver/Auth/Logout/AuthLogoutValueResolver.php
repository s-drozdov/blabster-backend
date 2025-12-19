<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Http\ValueResolver\Auth\Logout;

use Override;
use Webmozart\Assert\Assert;
use Blabster\Infrastructure\Enum\CookieKey;
use Symfony\Component\HttpFoundation\Request;
use Blabster\Infrastructure\Enum\RequestKey;
use Blabster\Application\Bus\CqrsElementInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Blabster\Infrastructure\Http\ValueResolver\AbstractValueResolver;
use Blabster\Application\UseCase\Command\User\Logout\UserLogoutCommand;

/**
 * @extends AbstractValueResolver<UserLogoutCommand>
 */
final readonly class AuthLogoutValueResolver extends AbstractValueResolver
{
    public function __construct(
        private DenormalizerInterface $denormalizer,
        ValidatorInterface $validator,
    ) {
        parent::__construct(validator: $validator);
    }

    #[Override]
    protected function getTargetClass(): string
    {
        return UserLogoutCommand::class;
    }

    #[Override]
    protected function createFromRequest(Request $request): CqrsElementInterface
    {
        $refreshToken = $request->cookies->get(CookieKey::RefreshToken->value);
        Assert::notEmpty($refreshToken);

        return $this->denormalizer->denormalize(
            array_merge(
                $request->toArray(),
                [RequestKey::RefreshTokenValue->value => $refreshToken],
            ),
            UserLogoutCommand::class,
        );
    }
}
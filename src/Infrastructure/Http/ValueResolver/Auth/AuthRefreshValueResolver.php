<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Http\ValueResolver\Auth;

use Override;
use Webmozart\Assert\Assert;
use Blabster\Infrastructure\Enum\CookieKey;
use Symfony\Component\HttpFoundation\Request;
use Blabster\Application\Bus\CqrsElementInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Blabster\Infrastructure\Http\ValueResolver\AbstractValueResolver;
use Blabster\Application\UseCase\Command\Auth\Refresh\AuthRefreshCommand;

/**
 * @extends AbstractValueResolver<AuthRefreshCommand>
 */
final readonly class AuthRefreshValueResolver extends AbstractValueResolver
{
    private const string REFRESH_TOKEN_VALUE = 'refresh_token_value';

    public function __construct(
        private DenormalizerInterface $denormalizer,
        ValidatorInterface $validator,
    ) {
        parent::__construct(validator: $validator);
    }

    #[Override]
    protected function getTargetClass(): string
    {
        return AuthRefreshCommand::class;
    }

    #[Override]
    protected function createFromRequest(Request $request): CqrsElementInterface
    {
        $refreshToken = $request->cookies->get(CookieKey::RefreshToken->value);
        Assert::notEmpty($refreshToken);

        return $this->denormalizer->denormalize(
            array_merge(
                $request->toArray(),
                [self::REFRESH_TOKEN_VALUE => $refreshToken],
            ),
            AuthRefreshCommand::class,
        );
    }
}
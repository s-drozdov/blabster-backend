<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Http\ValueResolver\Auth;

use Override;
use Symfony\Component\HttpFoundation\Request;
use Blabster\Application\Bus\CqrsElementInterface;
use Blabster\Application\UseCase\Command\Auth\Login\AuthLoginCommand;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Blabster\Infrastructure\Http\ValueResolver\AbstractValueResolver;

/**
 * @extends AbstractValueResolver<AuthLoginCommand>
 */
final readonly class AuthLoginValueResolver extends AbstractValueResolver
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
        return AuthLoginCommand::class;
    }

    #[Override]
    protected function createFromRequest(Request $request): CqrsElementInterface
    {
        return $this->denormalizer->denormalize(
            $request->toArray(), 
            AuthLoginCommand::class,
        );
    }
}
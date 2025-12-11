<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Http\ValueResolver\Otp;

use Override;
use Symfony\Component\HttpFoundation\Request;
use Blabster\Application\Bus\CqrsElementInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Blabster\Application\UseCase\Command\Otp\Create\OtpCreateCommand;
use Blabster\Infrastructure\Http\ValueResolver\AbstractValueResolver;

/**
 * @extends AbstractValueResolver<OtpCreateCommand>
 */
final readonly class OtpCreateValueResolver extends AbstractValueResolver
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
        return OtpCreateCommand::class;
    }

    #[Override]
    protected function createFromRequest(Request $request): CqrsElementInterface
    {
        return $this->denormalizer->denormalize(
            $request->toArray(), 
            OtpCreateCommand::class,
        );
    }
}
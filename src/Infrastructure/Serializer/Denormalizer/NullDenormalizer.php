<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Serializer\Denormalizer;

use Override;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Blabster\Library\Enum\PhpType;

final class NullDenormalizer implements DenormalizerInterface
{
    /**
     * @param mixed $data
     */
    #[Override]
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        return null;
    }

    #[Override]
    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === PhpType::null->value;
    }

    /**
     * @return array<class-string|'*'|'object'|string, bool|null>
     */
    #[Override]
    public function getSupportedTypes(?string $format): array
    {
        return [
            PhpType::null->value => true,
        ];
    }
}

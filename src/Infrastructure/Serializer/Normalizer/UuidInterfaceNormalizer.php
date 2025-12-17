<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Serializer\Normalizer;

use Override;
use LogicException;
use Blabster\Domain\ValueObject\UuidInterface;
use Blabster\Library\Helper\Uuid\UuidHelperInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final readonly class UuidInterfaceNormalizer implements NormalizerInterface, DenormalizerInterface
{
    private const string ERROR_NOT_UUID = '$data must be an instanse of UuidInterface, %s given';

    public function __construct(
        private UuidHelperInterface $uuidHelper,
    ) {
        /*_*/
    }

    /**
     * @return string
     */
    #[Override]
    public function normalize(mixed $data, ?string $format = null, array $context = []): string
    {
        if ($data instanceof UuidInterface) {
            return (string) $data;
        }

        throw new LogicException(
            sprintf(
                self::ERROR_NOT_UUID,
                get_debug_type($data),
            ),
        );
    }
    
    #[Override]
    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof UuidInterface;
    }

    /**
     * @param string $data
     */
    #[Override]
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        return $this->uuidHelper->fromString($data);
    }

    #[Override]
    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return is_a($type, UuidInterface::class, true) && is_string($data);
    }

    /**
     * @return array<class-string|'*'|'object'|string, bool|null>
     */
    #[Override]
    public function getSupportedTypes(?string $format): array
    {
        return [
            UuidInterface::class => true,
        ];
    }
}

<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Serializer\Normalizer;

use Override;
use LogicException;
use Blabster\Library\Collection\Map;
use Blabster\Library\Collection\MapInterface;
use Blabster\Library\Enum\SerializationContextParam;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;

final class MapInterfaceNormalizer implements NormalizerInterface, DenormalizerInterface, NormalizerAwareInterface, DenormalizerAwareInterface
{
    use NormalizerAwareTrait;
    use DenormalizerAwareTrait;

    private const string DATA = 'data';
    private const string INNER_TYPE = 'innerType';
    private const string DEFAULT_MAP = Map::class;
    private const string ERROR_NOT_MAP_INTERFACE = '$data must be an instanse of MapInterface, %s given';
    private const string BAD_DATA_FORMAT = 'normalized $data must be an array with [\'data\' => ..., \'innerType\' => ...] structure';

    /**
     * @return array<array-key,mixed>
     */
    #[Override]
    public function normalize(mixed $data, ?string $format = null, array $context = []): array
    {
        if (!$data instanceof MapInterface) {
            throw new LogicException(
                sprintf(
                    self::ERROR_NOT_MAP_INTERFACE,
                    get_debug_type($data),
                ),
            ); 
        }

        $result = $this->normalizer->normalize($this->getSourceArray($data, $context), $format, $context);

        /** @var array<array-key,mixed> $result */
        return $result;
    }
    
    #[Override]
    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof MapInterface;
    }

    /**
     * @param mixed[][] $data
     */
    #[Override]
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        if (!isset($data[self::DATA])) {
            throw new LogicException(
                self::BAD_DATA_FORMAT,
            ); 
        }

        if (!isset($data[self::INNER_TYPE])) {
            throw new LogicException(
                self::BAD_DATA_FORMAT,
            ); 
        }

        /** @var string $type */
        $type = $data[self::INNER_TYPE];

        $mapClass = $context['map_class'] ?? self::DEFAULT_MAP;

        /** @psalm-suppress MissingClosureParamType */
        array_walk($data[self::DATA], function (&$item) use ($type, $format, $context) {
            $item = $this->denormalizer->denormalize($item, $type, $format, $context);
        });
        
        return new $mapClass($data[self::DATA], $type);
    }

    #[Override]
    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        if (!is_array($data)) {
            return false;
        }

        return is_a($type, MapInterface::class, true);
    }

    /**
     * @return array<class-string|'*'|'object'|string, bool|null>
     */
    #[Override]
    public function getSupportedTypes(?string $format): array
    {
        return [
            MapInterface::class => true,
        ];
    }

    /**
     * @param MapInterface<array-key,mixed> $data
     * @param array<array-key,mixed> $context
     * 
     * @return array<array-key,mixed>
     */
    private function getSourceArray(MapInterface $data, array $context): array
    {
        if (isset($context[SerializationContextParam::isHttpResponse->value]) && $context[SerializationContextParam::isHttpResponse->value] === true) {
            return $data->toArray();
        }

        return ['data' => $data->toArray(), 'innerType' => $data->getInnerType()];
    }
}

<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Serializer\Normalizer;

use LogicException;

trait PhpSerializable
{
    private const string ERROR_NOT_OBJECT = '$data must be an object, %s given';
    private const string ERROR_NOT_STRING = '$data must be a string, %s given';

    /**
     * @param array<array-key, mixed> $context
     */
    public function normalize(mixed $data, ?string $format = null, array $context = []): string
    {
        if (is_object($data)) {
            return serialize($data);
        }

        throw new LogicException(
            sprintf(
                self::ERROR_NOT_OBJECT,
                get_debug_type($data),
            ),
        );
    }

    /**
     * @param array<array-key, mixed> $context
     */
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        if (is_string($data)) {
            return unserialize($data);
        }
        
        throw new LogicException(
            sprintf(
                self::ERROR_NOT_STRING,
                get_debug_type($data),
            ),
        );
    }
    
    /**
     * @param array<array-key, mixed> $context
     */
    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        if (is_object($data)) {
            return $this->isAllowed($data);
        }
        
        throw new LogicException(
            sprintf(
                self::ERROR_NOT_OBJECT,
                get_debug_type($data),
            ),
        );
    }

    /**
     * @param array<string, bool|null> $context
     */
    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $this->isAllowed($type) && is_string($data);
    }

    /**
     * @return array<string, bool|null>
     */
    public function getSupportedTypes(?string $format): array
    {
        return array_combine(
            $this->getAllowedClassList(), 
            array_map(
                fn (string $class) => true,
                $this->getAllowedClassList(),
            ),
        );
    }

    private function isAllowed(mixed $target): bool
    {
        if (in_array($target, $this->getAllowedClassList(), true)) {
            return true;
        }

        if (!is_object($target)) {
            return false;
        }

        foreach ($this->getAllowedClassList() as $allowedClass) {
            if ($target instanceof $allowedClass) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array<array-key, class-string>
     */
    abstract private function getAllowedClassList(): array;
}

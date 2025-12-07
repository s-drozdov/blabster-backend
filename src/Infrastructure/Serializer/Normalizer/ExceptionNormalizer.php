<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Serializer\Normalizer;

use Override;
use Throwable;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final readonly class ExceptionNormalizer implements NormalizerInterface
{
    use PhpSerializable;

    #[Override]
    private function getAllowedClassList(): array
    {
        return [
            Throwable::class,
        ];
    }
}

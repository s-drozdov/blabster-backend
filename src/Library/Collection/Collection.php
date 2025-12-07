<?php

declare(strict_types=1);

namespace Blabster\Library\Collection;

use Override;
use Blabster\Library\Collection\Arrayable;

/**
 * @template T
 * 
 * @implements ListInterface<T>
 */
final readonly class Collection implements ListInterface
{
    /** @use Arrayable<array-key, T> */
    use Arrayable;

    public function __construct(
        /** @var array<T> */
        private array $value,

        private ?string $innerType,
    ) {
        /*_*/
    }

    /**
     * @return array<T>
     */
    #[Override]
    public function toArray(): array
    {
        return $this->value;
    }

    #[Override]
    public function getInnerType(): ?string
    {
        return $this->innerType;
    }
}

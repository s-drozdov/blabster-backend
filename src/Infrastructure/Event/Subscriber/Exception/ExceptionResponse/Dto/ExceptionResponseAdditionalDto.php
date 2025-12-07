<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Event\Subscriber\Exception\ExceptionResponse\Dto;

use Override;
use Stringable;
use ArrayIterator;
use IteratorAggregate;
use Blabster\Library\Collection\Arrayable;
use Blabster\Library\Collection\ArrayableInterface;

/**
 * @implements ArrayableInterface<string, array<string,non-empty-list<string|Stringable>>>
 * @implements IteratorAggregate<string, array<string,non-empty-list<string|Stringable>>>
 */
final readonly class ExceptionResponseAdditionalDto implements ArrayableInterface, IteratorAggregate
{
   /**
     * @use Arrayable<string, array<string, non-empty-list<string|Stringable>>>
     */
    use Arrayable;

    public function __construct(

        /** @var array<string, non-empty-list<string|Stringable>> */
        private array $errors,
    ) {
        /*_*/
    }

    #[Override]
    public function toArray(): array
    {
        return [
            'errors' => $this->errors,
        ];
    }

    /**
     * @return ArrayIterator<string, array<string,non-empty-list<string|Stringable>>>
     */
    #[Override]
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator(
            $this->toArray(),
        );
    }
}

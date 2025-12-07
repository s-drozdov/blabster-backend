<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Bus\Processor;

use Symfony\Component\Serializer\SerializerInterface;
use Blabster\Application\Bus\Query\QueryInterface;
use Blabster\Application\Bus\Query\QueryResultInterface;
use Blabster\Infrastructure\Bus\QueryBusInterface;

/**
 * @template TElement of QueryInterface
 * @template TResult of QueryResultInterface
 * 
 * @extends AbstractCommandBusProcessor<TElement, TResult>
 */
final readonly class CommandBusQueryProcessor extends AbstractCommandBusProcessor
{
    /** 
     * @param QueryBusInterface<TElement, TResult> $queryBus
     */
    public function __construct(QueryBusInterface $queryBus,
                                SerializerInterface $serializer)
    {
        parent::__construct($queryBus, $serializer);
    }
}

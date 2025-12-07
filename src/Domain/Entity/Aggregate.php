<?php

declare(strict_types=1);

namespace Blabster\Domain\Entity;

abstract class Aggregate implements AggregateInterface
{
    use Eventable;
}

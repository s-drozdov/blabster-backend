<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Event\Subscriber\Exception\Exception\Specification;

use Throwable;
use Blabster\Library\Specification\SpecificationInterface;

final class ExceptionSpecification implements SpecificationInterface
{
    public function isSatisfiedBy(?Throwable $exception, string $type): bool
    {
        if (is_null($exception)) {
            return false;
        }

        if ($exception instanceof $type) {
            return true;
        }

        return false;
    }
}

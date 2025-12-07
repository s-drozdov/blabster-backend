<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Event\Subscriber\Exception\ExceptionResponse;

use Throwable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @template T of Throwable
 */
interface ExceptionResponseProviderInterface
{
    /**
     * @param T $exception
     */
    public function get(Throwable $exception, Request $request): ?Response;
}

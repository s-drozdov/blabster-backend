<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Event\Subscriber\Exception\EventResponse;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

interface EventResponseProviderInterface
{
    public function get(ExceptionEvent $event): ?Response;
}

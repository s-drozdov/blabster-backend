<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Event\Subscriber\Exception\EventResponse;

use Override;
use Throwable;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Blabster\Infrastructure\Event\Subscriber\Exception\Exception\ExceptionProvider;
use Blabster\Infrastructure\Event\Subscriber\Exception\ExceptionResponse\ExceptionResponseProviderInterface;

final class EventResponseDispatcher implements EventResponseProviderInterface
{
    public function __construct(
        /** @var array<string, ExceptionResponseProviderInterface<Throwable>> */
        private array $typeToProviderMap,

        private DefaultEventResponseProvider $defaultEventResponseProvider,
        private ExceptionProvider $exceptionProvider,
    ) {
        /*_*/
    }

    /**
     * @inheritdoc
     */
    #[Override]
    public function get(ExceptionEvent $event): ?Response
    {
        foreach ($this->typeToProviderMap as $type => $provider) {
            $exception = $this->exceptionProvider->get($event, $type);

            if ($exception !== null) {
                return $provider->get($exception, $event->getRequest());
            }
        }

        return $this->defaultEventResponseProvider->get($event);
    }
}

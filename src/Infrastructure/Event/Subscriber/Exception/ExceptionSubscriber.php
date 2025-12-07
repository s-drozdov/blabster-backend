<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Event\Subscriber\Exception;

use Override;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Blabster\Infrastructure\Event\Subscriber\Exception\EventResponse\EventResponseProviderInterface;

/**
 * to get exceptions in html for debug
 * put in .env
 * IS_HTML_EXCEPTIONS=1
 */
final class ExceptionSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private ContainerBagInterface $params,
        private EventResponseProviderInterface $eventResponseProviderInterface,
    ) {
        /*_*/
    }

    #[Override]
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        if ((bool) $this->params->get('isHtmlExceptions')) {
            return;
        }

        $response = $this->eventResponseProviderInterface->get($event);

        if (is_null($response)) {
            return;
        }

        $event->setResponse($response);
    }
}

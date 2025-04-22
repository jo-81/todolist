<?php

namespace App\EventSubscriber;

use Symfony\UX\TwigComponent\Event\PreRenderEvent;
use App\Security\LiveComponent\LiveComponentSecurityHandler;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LiveComponentSecuritySubscriber implements EventSubscriberInterface
{
    public function __construct(
        private LiveComponentSecurityHandler $securityHandler,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            PreRenderEvent::class => ['onPreMount', 10],
        ];
    }

    public function onPreMount(PreRenderEvent $event): void
    {
        $component = $event->getComponent();
        $this->securityHandler->handleComponentSecurity($component);
    }
}

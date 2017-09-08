<?php

namespace App\ProjectBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\ProjectBundle\Event\ProducerWatchEvent;
use Psr\Log\LoggerInterface;

class ProducerSubscriber implements EventSubscriberInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    
    public static function getSubscribedEvents()
    {
        return array(
            ProducerWatchEvent::NAME => array(
                array('onProducerWatch', 10),
            ),
        );
    }

    public function onProducerWatch(ProducerWatchEvent $event)
    {
        $this->logger->info('Hello from ProducerSubscriber!');
    }
}

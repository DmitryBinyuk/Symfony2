<?php

namespace App\ProjectBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\ProjectBundle\Event\ProductWatchEvent;
use Psr\Log\LoggerInterface;

class ProductSubscriber implements EventSubscriberInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    
    public static function getSubscribedEvents()
    {
        return array(
            ProductWatchEvent::NAME => array(
                array('onProductWatch', 10),
            ),
        );
    }

    public function onProductWatch(ProductWatchEvent $event)
    {
        $this->logger->info('Hello from ProductSubscriber!');
    }
}

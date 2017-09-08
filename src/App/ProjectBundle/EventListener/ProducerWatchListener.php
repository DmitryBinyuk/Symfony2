<?php

namespace App\ProjectBundle\EventListener;

use App\ProjectBundle\Event\ProducerWatchEvent;
use Doctrine\ORM\EntityManager;

class ProducerWatchListener
{
    protected $em;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function onProducerWatch(ProducerWatchEvent $event)
    {
        $producer = $event->getProducer();

        $producerWatches = $producer->getWatches();

        $producerWatches++;

        $producer->setWatches($producerWatches);

        $this->em->persist($producer);
        $this->em->flush();
	
    }
}


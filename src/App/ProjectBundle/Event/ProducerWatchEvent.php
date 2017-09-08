<?php

namespace App\ProjectBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use App\ProjectBundle\Entity\Producer;

class ProducerWatchEvent extends Event
{
    const NAME = 'producer.watch';
    
    protected $producer;


    public function __construct(Producer $producer)
    {
	    $this->producer = $producer;
    }
    
    public function getProducer()
    {
	    return $this->producer;
    }
}


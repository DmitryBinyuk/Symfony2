<?php

namespace App\ProjectBundle\EventListener;

use App\ProjectBundle\Event\ProductWatchEvent;
use Doctrine\ORM\EntityManager;

class ProductWatchListener
{
    protected $em;
    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function onProductWatch(ProductWatchEvent $event)
    {
        $product = $event->getProduct();

        $productWatches = $product->getWatches();

        $productWatches++;

        $product->setWatches($productWatches);

        $this->em->persist($product);
        $this->em->flush();
	
    }
}


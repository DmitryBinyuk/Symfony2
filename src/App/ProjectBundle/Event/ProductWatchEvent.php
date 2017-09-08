<?php

namespace App\ProjectBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use App\ProjectBundle\Entity\Product;

class ProductWatchEvent extends Event
{
    const NAME = 'product.watch';
    
    protected $product;


    public function __construct(Product $product)
    {
	$this->product = $product;
    }
    
    public function getProduct()
    {
	return $this->product;
    }
}


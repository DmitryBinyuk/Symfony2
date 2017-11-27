<?php

namespace App\ProjectBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\ProjectBundle\Entity\Product;

class LoadProductData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $count = 5;
	    $IsAct = true;
        
        for ($x = 0; $x <= $count; $x++) {
            $newProduct = new Product();
            
            $newProduct->setName('name_'.$x);
            $newProduct->setDescription('description_'.$x);
            $newProduct->setPrice($x*$x);
            $manager->persist($newProduct);
        }
        
        $manager->flush();
    }
}
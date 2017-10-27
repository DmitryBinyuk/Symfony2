<?php

namespace App\ProjectBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;
use App\ProjectBundle\Entity\Product;

class ProductService
{
    /**
     * @var EntityManager $em
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getRelatedProducts($productId)
    {
        $product = $this->em->getRepository(Product::class)->find($productId);

        if(!is_null($product->getCategory())){


            $relatedProducts = $this->em->getRepository(Product::class)
                                        ->findRelated(['category' => $product->getCategory()->getId(), 'id' => $product->getId()]);

            return $relatedProducts;
        }

        return [];

    }
}


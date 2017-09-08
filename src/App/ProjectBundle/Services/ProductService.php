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

        $relatedProducts = $this->em->getRepository(Product::class)
            ->findBy(
                array(
                    'category' => $product->getCategory(),
                )
            );

        return $relatedProducts;
    }
}


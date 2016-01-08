<?php

namespace App\ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\ProjectBundle\Entity\Product;

class ProductController extends Controller
{
    /**
     * @Route("/product/{id}", name="product")
     * @Template()
     */
    public function showAction($id)
    {  
//        $repository = $this->getDoctrine()->getRepository('AppProjectBundle:Product');
//        $product = $repository->createQueryBuilder('p')
//            ->where('p.id = :id')
//            ->setParameter('id', $id)
//            ->getQuery();
//
//        $paginator  = $this->get('knp_paginator');
//        $pagination = $paginator->paginate(
//            $product,
//            $request->query->get('page', 1),
//            10
//        );
        
//        $id = $product->getId();
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        
        $qb->select('d')
            ->from('\App\ProjectBundle\Entity\Product', 'd')
            ->where('d.id = :id')
            ->setParameter('id', $id);
        
        $product = $qb->getQuery();
        $product = $product->getResult();
        
//    var_dump($product);
//    die('test_pro');
        
        return $this->render('AppProjectBundle:Product:show.html.twig', array('product' => $product));
    }

}

<?php

namespace App\ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use App\ProjectBundle\Entity\Product;

class ProductsController extends Controller
{
    /**
     * @Route("/products", name="products")
     * @Template()
     */
    public function showAction(Request $request)
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $products = $em->getRepository('AppProjectBundle:Product')->getAllProducts();
        $products = $products->getResult();
        
        //using query builder
//        $qbcities = $em->createQueryBuilder();
//        $qbcities->select('dc')
//                ->from('\App\ProjectBundle\Entity\Product', 'dc');
//        
//        $a = $qbcities->getQuery()->getResult();
//        var_dump($a);
        
//        var_dump($products);
//die('test1');

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $products,
            $request->query->get('page', 1),
            4
        );

//        return array(
//            'pagination' => $pagination,
//            'products' => $products
//        );
        
        return $this->render('AppProjectBundle:Products:show.html.twig', array('pagination' => $pagination, 'products' => $products));
    }

}

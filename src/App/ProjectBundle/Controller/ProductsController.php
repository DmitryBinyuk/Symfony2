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

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $products,
            $request->query->get('page', 1),
            4
        );

        
        return $this->render('AppProjectBundle:Products:show.html.twig', array('pagination' => $pagination, 'products' => $products));
    }

}

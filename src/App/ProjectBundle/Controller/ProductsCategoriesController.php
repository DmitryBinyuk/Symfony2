<?php

namespace App\ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use App\ProjectBundle\Entity\Product;

class ProductsCategoriesController extends Controller
{
    /**
     * @Route("/categories", name="categories")
     * @Template()
     */
    public function showAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('AppProjectBundle:ProductCategory')->getAllCategories();
        $categories = $categories->getResult();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $categories,
            $request->query->get('page', 1),
            4
        );
        
        return $this->render('AppProjectBundle:ProductsCategories:show.html.twig', array('pagination' => $pagination, 'categories' => $categories));
    }

}

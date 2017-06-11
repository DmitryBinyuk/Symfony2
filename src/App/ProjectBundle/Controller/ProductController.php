<?php

namespace App\ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\ProjectBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller {

    /**
     * @Route("/product/{id}", name="product")
     * @Template()
     */
    public function showAction($id) {
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
    
    /**
     * @Route("/product_get_search", name="product_get_search")
     * @Template()
     */
    public function getAjaxSearch() {
        
        return $this->render('AppProjectBundle:Product:search.html.twig', array());
    }

    /**
     * @Route("/product_search", name="product_search")
     * @Template()
     */
    public function ajaxSearch(Request $request) {
        
//        $request = $this->container->get('data');   
//        $isAjax = $this->get('Request')->isXMLHttpRequest();
//    if ($isAjax) {     
//        var_dump($is);
//        return new Response('This is ajax response');
//    }
        
        //for XMLHttPRequest
//        $keyword = $request->getContent();
        
        //works
        $keyword =$request->request->all();
//        $keyword =$request->request->all();
//        $id =$request->query->get('search_val');//for get
//    $keyword =$request->request->get('imagebase64');
        
//
    var_dump($keyword);
    die('test');
        
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        $qb->select('d')
                ->from('\App\ProjectBundle\Entity\Product', 'd')
                ->where('d.name LIKE :name')
                ->setParameter('name', '%'.$keyword.'%')
                ->select('d.name');

        $product = $qb->getQuery();
        $product = $product->getResult();

//        var_dump($product);
//        die('$a');

        return new Response(json_encode($product));
        
//        $repository = $this->getDoctrine()->getRepository('AppProjectBundle:Product');
//        $product = $repository->findOneByName($keyword);
        
        var_dump($product);
        die('test');
    }

}

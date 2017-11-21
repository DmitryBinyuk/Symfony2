<?php

namespace App\ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use App\ProjectBundle\Entity\Product;
use Elasticsearch\ClientBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;

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

    /**
     * @Route("/products-search", name="products-search")
     * @Method("POST")
     */
    public function searchProductAction(Request $request)
    {
        $client = ClientBuilder::create()->build();

        //Get DB name
        $index = $this->container->getParameter('database_name');

        //SEARCH
        $searchText = $request->request->get('searchText');
        $params = [
            'index' => $index,
            'type' => 'Product',
            'body' => [
                'query' => [
                    'wildcard' => [
                        'name' => $searchText.'*'
                    ]
                ]
            ]
        ];

        $responseSEARCH = $client->search($params);

        $resultResponce = [];
        foreach($responseSEARCH['hits']['hits'] as $key=>$value){
            $resultResponce[] = $value['_source'];
        }

        $response = new JsonResponse();
        $response->setData($resultResponce);

        return $response;
    }

}

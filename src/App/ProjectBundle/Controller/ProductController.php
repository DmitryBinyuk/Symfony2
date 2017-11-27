<?php

namespace App\ProjectBundle\Controller;

use App\ProjectBundle\Entity\Comment;
use App\ProjectBundle\Entity\ProductCategory;
use Buzz\Message\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\ProjectBundle\Entity\Product;
use App\ProjectBundle\Services\WeatherService;
use Symfony\Component\HttpFoundation\Response;
use App\ProjectBundle\Entity\DeliveryService;
use App\ProjectBundle\Event\ProductWatchEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\ProjectBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductController extends Controller
{
    /**
     * @Route("/product/{id}", name="product")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        $qb->select('d')
            ->from('\App\ProjectBundle\Entity\Product', 'd')
            ->where('d.id = :id')
            ->setParameter('id', $id);

        $product = $qb->getQuery();

        $product = $product->getResult();

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $weatherService = $this->get('weather.service');
//        $weather = $weatherService->getWeather();

        //Get related products
        $productService = $this->get('product.service');
        $relatedProducts = $productService->getRelatedProducts($id);
	
	    //Dispatch Event
	    $product = $this->getDoctrine()->getRepository(Product::class)->find($id);

	    $event = new ProductWatchEvent($product);
	
	    $dispatcher = $this->get('event_dispatcher');
	
        $dispatcher->dispatch(ProductWatchEvent::NAME, $event);

        //Get all categories
        $categories = $this->getDoctrine()->getRepository(ProductCategory::class)->findAll();

        $managers = $product->getManagers();

        $discount = $product->getDiscount();

        $comments = $product->getComments();

        $paginator  = $this->get('knp_paginator');

        $request = $this->get('request');

        $pagination = $paginator->paginate(
            $comments, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );

        return $this->render('AppProjectBundle:Product:show.html.twig',
                            array('product' => $product,
                                  'relatedProducts' => $relatedProducts,
                                  'categories' => $categories,
                                  'managers' => $managers,
                                  'discount' => $discount,
                                  'comments' => $comments,
                                  'pagination' => $pagination));//, 'weather' => $weather));
    }

    /**
     * @Route("/product/{id}/attach-category/{categoryId}")
     */
    public function attachCategory($id, $categoryId)
    {
        $repositoryProduct = $this->getDoctrine()->getRepository(Product::class);

        $product = $repositoryProduct->find($id);

        $repositoryCategory = $this->getDoctrine()->getRepository(ProductCategory::class);

        $productCategory = $repositoryCategory->find($categoryId);


        $product->setCategory($productCategory);

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();

        return new Response('Ok');
    }

    /**
     * @Route("/product/{id}/add-delivery-service/{deliveryId}")
     */
    public function addDeliveryService()
    {
        $repositoryProduct = $this->getDoctrine()->getRepository(Product::class);

        $product = $repositoryProduct->find($id);

        $repositoryDeliveryService = $this->getDoctrine()->getRepository(DeliveryService::class);

        $productDeliveryService = $repositoryDeliveryService->find($deliveryId);

        $product->addDeliveryService();

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();

        return new Response('Ok');
    }

    /**
     * @Route("/product/{id}/add-comment")
     * @Method("POST")
     */
    public function addCommentAction($id)//Request $request,
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $request = $this->get('request');

        $comment = new Comment();
        $comment->setTitle($request->request->get('title'));
        $comment->setBody($request->request->get('body'));
        $comment->setProduct($product);
        $comment->setUser($user);

        $em = $this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush();

        $response = new JsonResponse();
        $response->setData(['title' => $request->request->get('title'), 'body' => $request->request->get('body')]);

        return $response;
    }
}

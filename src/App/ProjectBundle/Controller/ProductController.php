<?php

namespace App\ProjectBundle\Controller;

use App\ProjectBundle\Entity\ProductCategory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\ProjectBundle\Entity\Product;
use App\ProjectBundle\Services\WeatherService;
use Symfony\Component\HttpFoundation\Response;
use App\ProjectBundle\Entity\DeliveryService;

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

        $weatherService = $this->get('weather.service');
//        $weather = $weatherService->getWeather();

        return $this->render('AppProjectBundle:Product:show.html.twig', array('product' => $product));//, 'weather' => $weather));
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
}

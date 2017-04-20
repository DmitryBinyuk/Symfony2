<?php

namespace App\ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\ProjectBundle\Entity\Product;
use App\ProjectBundle\Services\WeatherService;

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
        $weather = $weatherService->getWeather();

        return $this->render('AppProjectBundle:Product:show.html.twig', array('product' => $product, 'weather' => $weather));
    }

}

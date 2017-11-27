<?php

namespace App\ProjectBundle\Controller;

use App\ProjectBundle\Entity\Producer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use App\ProjectBundle\Event\ProducerWatchEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ProducersController extends Controller
{
    /**
     * @Route("/producers", name="producers")
     * @Template()
     */
    public function indexAction(Request $request)
    {
	    //Test services for fun
        $logger = $this->container->get('logger');
        $logger->info('Look! test services for fun!');
	
        $em = $this->getDoctrine()->getManager();
        
        $producers = $em->getRepository('AppProjectBundle:Producer')->getAllProducers();
        $producers = $producers->getResult();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $producers,
            $request->query->get('page', 1),
            4
        );
        
        return $this->render('AppProjectBundle:Producers:index.html.twig',
                            array('pagination' => $pagination, 'producers' => $producers));
    }

    /**
     * @Route("/producer/{id}", name="producer")
     * @Template()
     */
    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        $qb->select('p')
            ->from('\App\ProjectBundle\Entity\Producer', 'p')
            ->where('p.id = :id')
            ->setParameter('id', $id);

        $producer = $qb->getQuery();
        $producer = $producer->getResult();

        //Dispatch Event
        $producer = $this->getDoctrine()->getRepository(Producer::class)->find($id);

        $event = new ProducerWatchEvent($producer);

        $dispatcher = $this->get('event_dispatcher');

        $dispatcher->dispatch(ProducerWatchEvent::NAME, $event);

        return $this->render('AppProjectBundle:Producers:show.html.twig',
                            array('producer' => $producer));
    }

}

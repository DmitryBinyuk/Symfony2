<?php

namespace Custom\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\ProjectBundle\Entity\DeliveryService;
use Symfony\Component\HttpFoundation\Request;

class DeliveryServiceController extends Controller
{
    /**
     * @Route("/delivery-services", name="admin-delivery-services")
     * @Template()
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository(DeliveryService::class);

        $deliveryServices = $repository->findAll();

        return $this->render('CustomAdminBundle:DeliveryService:index.html.twig',
                                array('deliveryServices' => $deliveryServices));
    }

    /**
     * @Route("/delivery-services/create", name="admin-delivery-services-create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $deliveryService = new DeliveryService();

        $form = $this->createFormBuilder($deliveryService)
            ->add('name', 'text', array('attr' => array('class' => 'form-control')))
            ->add('pricePerKilometer', 'text', array('attr' => array('class' => 'form-control')))
            ->add('save', 'submit', array('label' => 'Create Delivery Service',
                'attr' => array('class' => 'btn btn-success')))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $deliveryService = $form->getData();

            $em = $this->getDoctrine()->getManager();

            $em->persist($deliveryService);
            $em->flush();

            return $this->redirectToRoute('admin-delivery-services');
        }

        return $this->render('CustomAdminBundle:DeliveryService:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/delivery-services/update/{id}", name="admin-delivery-services-update")
     * @Template()
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $deliveryService = $em->getRepository(DeliveryService::class)->find($id);

        if (!$deliveryService) {
            throw $this->createNotFoundException('The delivery service does not exist');
        }

        $form = $this->createFormBuilder($deliveryService)
            ->add('name', 'text', array('attr' => array('class' => 'form-control')))
            ->add('pricePerKilometer', 'text', array('attr' => array('class' => 'form-control')))
            ->add('save', 'submit', array('label' => 'Update',
                'attr' => array('class' => 'btn btn-success')))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $deliveryService = $form->getData();

            $em = $this->getDoctrine()->getManager();

            $em->persist($deliveryService);
            $em->flush();

            return $this->redirectToRoute('admin-delivery-services');
        }

        return $this->render('CustomAdminBundle:DeliveryService:update.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/delivery-services/show/{id}", name="admin-delivery-services-show")
     * @Template()
     */
    public function showAction($id)
    {
        $repository = $this->getDoctrine()
            ->getRepository(DeliveryService::class);

        $deliveryService = $repository->find($id);

        if (!$deliveryService) {
            throw $this->createNotFoundException('The delivery service does not exist');
        }

        return $this->render('CustomAdminBundle:DeliveryService:show.html.twig', array('deliveryService' => $deliveryService));
    }

    /**
     * @Route("/delivery-services/delete/{id}", name="admin-delivery-services-delete")
     * @Template()
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(DeliveryService::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No delivery service found for id '.$id
            );
        }

        $comments = $product->getComments();

        foreach ($comments as $comment){
            $product->removeComment($comment);
            $comment->setProduct(null);
        }


//        $em->remove($product);
        $em->flush();

        return $this->redirectToRoute('admin-products');
    }
}

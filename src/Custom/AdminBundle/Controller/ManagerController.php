<?php

namespace Custom\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\ProjectBundle\Entity\Manager;
use Symfony\Component\HttpFoundation\Request;

class ManagerController extends Controller
{
    /**
     * @Route("/managers", name="admin-managers")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery('SELECT m FROM AppProjectBundle:Manager m');

        $managers = $query->getResult();

        return $this->render('CustomAdminBundle:Manager:index.html.twig', array('managers' => $managers));
    }

    /**
     * @Route("/managers/create", name="admin-managers-create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $manager = new Manager();

        $form = $this->createFormBuilder($manager)
            ->add('fullname', 'text')
            ->add('position', 'text')
            ->add('phone', 'text')
            ->add('contact_email', 'text')
            ->add('save', 'submit', array('label' => 'Create Manager'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $form->getData();

            $em = $this->getDoctrine()->getManager();

            $em->persist($manager);
            $em->flush();

            return $this->redirectToRoute('admin-managers');
        }

        return $this->render('CustomAdminBundle:Manager:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/managers/update/{id}", name="admin-managers-update")
     * @Template()
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $manager = $em->getRepository(Manager::class)->find($id);

        if (!$manager) {
            throw $this->createNotFoundException(
                'No manager found for id '.$id
            );
        }

        $form = $this->createFormBuilder($manager)
            ->add('fullname', 'text')
            ->add('position', 'text')
            ->add('phone', 'text')
            ->add('contact_email', 'text')
            ->add('save', 'submit', array('label' => 'Update'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $form->getData();

            $em = $this->getDoctrine()->getManager();

            $em->persist($manager);
            $em->flush();

            return $this->redirectToRoute('admin-managers');
        }

        return $this->render('CustomAdminBundle:Manager:update.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/managers/show/{id}", name="admin-managers-show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(
            'SELECT m
             FROM AppProjectBundle:Manager m
             WHERE m.id = :id'
            )->setParameter('id', $id);

        $manager = $query->getSingleResult();

        return $this->render('CustomAdminBundle:Manager:show.html.twig', array('manager' => $manager));
    }

    /**
     * @Route("/managers/delete/{id}", name="admin-managers-delete")
     * @Template()
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $manager = $em->getRepository(Manager::class)->find($id);

        if (!$manager) {
            throw $this->createNotFoundException(
                'No manager found for id '.$id
            );
        }

        $products = $manager->getProducts();

        foreach ($products as $product){
            $manager->removeProduct($product);
            $product->removeManager($manager);
            $em->persist($manager);
        }

//        $em->remove($producer);
        $em->flush();

        return $this->redirectToRoute('admin-managers');
    }
}

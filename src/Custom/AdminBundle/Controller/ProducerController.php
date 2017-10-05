<?php

namespace Custom\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\ProjectBundle\Entity\Producer;
use Symfony\Component\HttpFoundation\Request;

class ProducerController extends Controller
{
    /**
     * @Route("/producers", name="admin-producers")
     * @Template()
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository(Producer::class);

        $query = $repository->createQueryBuilder('p')
            ->getQuery();

        $producers = $query->getResult();

        return $this->render('CustomAdminBundle:Producer:index.html.twig', array('producers' => $producers));
    }

    /**
     * @Route("/producers/create", name="admin-producers-create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $producer = new Producer();

        $form = $this->createFormBuilder($producer)
            ->add('name', 'text')
            ->add('country', 'text')
            ->add('description', 'text')
            ->add('save', 'submit', array('label' => 'Create Producer'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $producer = $form->getData();

            $em = $this->getDoctrine()->getManager();

            $em->persist($producer);
            $em->flush();

            return $this->redirectToRoute('admin-producers');
        }

        return $this->render('CustomAdminBundle:Producer:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/producers/update/{id}", name="admin-producers-update")
     * @Template()
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $producer = $em->getRepository(Producer::class)->find($id);

        if (!$producer) {
            throw $this->createNotFoundException(
                'No producer found for id '.$id
            );
        }

        $form = $this->createFormBuilder($producer)
            ->add('name', 'text')
            ->add('country', 'text')
            ->add('description', 'text')
            ->add('save', 'submit', array('label' => 'Update'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $product = $form->getData();

            $em = $this->getDoctrine()->getManager();

            $em->persist($producer);
            $em->flush();

            return $this->redirectToRoute('admin-producers');
        }

        return $this->render('CustomAdminBundle:Producer:update.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/producers/show/{id}", name="admin-producers-show")
     * @Template()
     */
    public function showAction($id)
    {
        $repository = $this->getDoctrine()
            ->getRepository(Producer::class);

        $query = $repository->createQueryBuilder('p')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        $producer = $query->getSingleResult();

        return $this->render('CustomAdminBundle:Producer:show.html.twig', array('producer' => $producer));
    }

    /**
     * @Route("/producers/delete/{id}", name="admin-producers-delete")
     * @Template()
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $producer = $em->getRepository(Producer::class)->find($id);

        if (!$producer) {
            throw $this->createNotFoundException(
                'No producer found for id '.$id
            );
        }

        $categories = $producer->getCategories();

        foreach ($categories as $category){
            $producer->removeCategory($category);
            $category->removeProducer($producer);
            $em->persist($producer);
        }


//        $em->remove($producer);
        $em->flush();

        return $this->redirectToRoute('admin-producers');
    }
}

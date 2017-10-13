<?php

namespace Custom\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\ProjectBundle\Entity\Discount;
use Symfony\Component\HttpFoundation\Request;

class DiscountController extends Controller
{
    /**
     * @Route("/discounts", name="admin-discounts")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery('SELECT d FROM AppProjectBundle:Discount d');

        $discounts = $query->getResult();

        return $this->render('CustomAdminBundle:Discount:index.html.twig',
            array('discounts' => $discounts));
    }

    /**
     * @Route("/discounts/create", name="admin-discounts-create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $discount = new Discount();

        $form = $this->createFormBuilder($discount)
            ->add('title', 'text')
            ->add('total_count', 'text')
            ->add('total_price', 'text')
            ->add('discount_size_percent', 'text')
            ->add('save', 'submit', array('label' => 'Create Discount'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $discount = $form->getData();

            $em = $this->getDoctrine()->getManager();

            $em->persist($discount);

            $em->flush();

            return $this->redirectToRoute('admin-discounts');
        }

        return $this->render('CustomAdminBundle:Discount:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/discounts/update/{id}", name="admin-discounts-update")
     * @Template()
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $discount = $em->getRepository(Discount::class)->find($id);

        if (!$discount) {
            throw $this->createNotFoundException(
                'No discount found for id '.$id
            );
        }

        $form = $this->createFormBuilder($discount)
            ->add('title', 'text')
            ->add('total_count', 'text')
            ->add('total_price', 'text')
            ->add('discount_size_percent', 'text')
            ->add('save', 'submit', array('label' => 'Update'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $query = $em->createQuery("UPDATE AppProjectBundle:Discount d SET d.title = :title,
                                        d.totalCount = :total_count, 
                                        d.totalPrice = :total_price, d.discountSizePercent = :discount_size_percent 
                                        WHERE d.id = :id");

            $query->setParameter('title', $form->getData()->getTitle());
            $query->setParameter('total_count', $form->getData()->getTotalCount());
            $query->setParameter('total_price', $form->getData()->getTotalPrice());
            $query->setParameter('discount_size_percent', $form->getData()->getDiscountSizePercent());
            $query->setParameter('id', $id);

            $query->execute();

            return $this->redirectToRoute('admin-discounts');
        }

        return $this->render('CustomAdminBundle:Discount:update.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/discounts/show/{id}", name="admin-discounts-show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(
            'SELECT d
             FROM AppProjectBundle:Discount d
             WHERE d.id = :id'
        )->setParameter('id', $id);

        $discount = $query->getSingleResult();

        return $this->render('CustomAdminBundle:Discount:show.html.twig', array('discount' => $discount));
    }

    /**
     * @Route("/discounts/delete/{id}", name="admin-discounts-delete")
     * @Template()
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery("UPDATE AppProjectBundle:Product p SET p.discount= NULL WHERE p.discount = :id");
        $query->setParameter('id', $id);

        $query->execute();

        $query = $em->createQuery("DELETE FROM AppProjectBundle:Discount d WHERE d.id = :id");
        $query->setParameter('id', $id);

        $query->execute();

        return $this->redirectToRoute('admin-discounts');
    }
}

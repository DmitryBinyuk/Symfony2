<?php

namespace Custom\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\ProjectBundle\Entity\ProductCategory;
use Symfony\Component\HttpFoundation\Request;

class ProductCategoryController extends Controller
{
    /**
     * @Route("/product-categories", name="admin-product-categories")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery('SELECT c FROM AppProjectBundle:ProductCategory c');

        $productCategories = $query->getResult();

        return $this->render('CustomAdminBundle:ProductCategory:index.html.twig',
                            array('productCategories' => $productCategories));
    }

    /**
     * @Route("/product-categories/create", name="admin-product-categories-create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $productCategory = new ProductCategory();

        $form = $this->createFormBuilder($productCategory)
            ->add('name', 'text')
            ->add('description', 'text')
            ->add('save', 'submit', array('label' => 'Create Category'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $productCategory = $form->getData();

            $em = $this->getDoctrine()->getManager();

            $em->persist($productCategory);

            $em->flush();

            return $this->redirectToRoute('admin-product-categories');
        }

        return $this->render('CustomAdminBundle:ProductCategory:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/product-categories/update/{id}", name="admin-product-categories-update")
     * @Template()
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $productCategory = $em->getRepository(ProductCategory::class)->find($id);

        if (!$productCategory) {
            throw $this->createNotFoundException(
                'No prodcut category found for id '.$id
            );
        }

        $form = $this->createFormBuilder($productCategory)
            ->add('name', 'text')
            ->add('description', 'text')
            ->add('save', 'submit', array('label' => 'Update'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $query = $em->createQuery("UPDATE AppProjectBundle:ProductCategory c SET c.name = :name, c.description = :description WHERE c.id = :id");

            $query->setParameter('name', $form->getData()->getName());
            $query->setParameter('description', $form->getData()->getDescription());
            $query->setParameter('id', $id);

            $query->execute();

            return $this->redirectToRoute('admin-product-categories');
        }

        return $this->render('CustomAdminBundle:ProductCategory:update.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/product-categories/show/{id}", name="admin-product-categories-show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(
            'SELECT c
             FROM AppProjectBundle:ProductCategory c
             WHERE c.id = :id'
        )->setParameter('id', $id);

        $productCategory = $query->getSingleResult();


        if (!$productCategory) {
            throw $this->createNotFoundException('The product category does not exist');
        }

        return $this->render('CustomAdminBundle:ProductCategory:show.html.twig', array('productCategory' => $productCategory));
    }

    /**
     * @Route("/product-categories/delete/{id}", name="admin-product-categories-delete")
     * @Template()
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery("UPDATE AppProjectBundle:Product p SET p.category= NULL WHERE p.category = :id");
        $query->setParameter('id', $id);

        $query->execute();

        $query = $em->createQuery("DELETE FROM AppProjectBundle:ProductCategory c WHERE c.id = ".$id);
//        $query->setParameter('id', $id);

        $query->execute();

        return $this->redirectToRoute('admin-product-categories');
    }
}

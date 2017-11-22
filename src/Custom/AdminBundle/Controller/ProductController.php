<?php

namespace Custom\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\ProjectBundle\Entity\Product;
use App\ProjectBundle\Entity\Comment;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
    /**
     * @Route("/products", name="admin-products")
     * @Template()
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository(Product::class);

        $products = $repository->findAll();

        return $this->render('CustomAdminBundle:Product:index.html.twig', array('products' => $products));
    }

    /**
     * @Route("/products/create", name="admin-products-create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $product = new Product();

        $form = $this->createFormBuilder($product)
            ->add('name', 'text')
            ->add('description', 'text')
            ->add('price', 'text')
            ->add('category', 'entity', array(
                'class' => 'AppProjectBundle:ProductCategory',
                'choice_label' => 'name',
            ))
            ->add('save', 'submit', array('label' => 'Create Product'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $product = $form->getData();

            $em = $this->getDoctrine()->getManager();

            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('admin-products');
        }

        return $this->render('CustomAdminBundle:Product:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/products/update/{id}", name="admin-products-update")
     * @Template()
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException('The product does not exist');
        }

        $form = $this->createFormBuilder($product)
            ->add('name', 'text')
            ->add('description', 'text')
            ->add('price', 'text')
            ->add('category', 'entity', array(
                'class' => 'AppProjectBundle:ProductCategory',
                'choice_label' => 'name',
                'placeholder' => 'Choose category',
            ))
            ->add('save', 'submit', array('label' => 'Update'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $product = $form->getData();

            $em = $this->getDoctrine()->getManager();

            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('admin-products');
        }

        return $this->render('CustomAdminBundle:Product:update.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/products/show/{id}", name="admin-products-show")
     * @Template()
     */
    public function showAction($id)
    {
        $repository = $this->getDoctrine()
            ->getRepository(Product::class);

        $product = $repository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('The product does not exist');
        }

        return $this->render('CustomAdminBundle:Product:show.html.twig', array('product' => $product));
    }

    /**
     * @Route("/products/delete/{id}", name="admin-products-delete")
     * @Template()
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
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

<?php

namespace Custom\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\ProjectBundle\Entity\Product;
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
            ->add('save', 'submit', array('label' => 'Create Product'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $product = $form->getData();

            $em = $this->getDoctrine()->getManager();

//            $product->setName($data['name']);
//            $product->setDescription($data['description']);
//            $product->setPrice($data['price']);

            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('admin-products');
        }

        return $this->render('CustomAdminBundle:Product:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/products/update", name="admin-products-update")
     * @Template()
     */
    public function updateAction()
    {

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

        return $this->render('CustomAdminBundle:Product:show.html.twig', array('product' => $product));
    }

}

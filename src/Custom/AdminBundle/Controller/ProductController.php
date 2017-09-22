<?php

namespace Custom\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ProductController extends Controller
{
    /**
     * @Route("/products")
     * @Template()
     */
    public function indexAction()
    {
        return array(
                // ...
            );    }

}

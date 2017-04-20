<?php

namespace App\ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use App\ProjectBundle\Entity\User;

class ProfileController extends Controller
{
    /**
     * @Route("/profile", name="profile")
     * @Template()
     */
    public function showAction(Request $request)
    {
	    $user = new User();

        $repository = $this->getDoctrine()->getRepository('AppProjectBundle:User');

        $user = $repository->find(1);

        var_dump($user);die;

        $form = $this->createFormBuilder($user)
            ->add('firstname', 'text', array('data' => 'Default value'))
            ->add('lastname', 'text')
            ->add('save', 'submit', array('label' => 'Update profile'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $user = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
             $em = $this->getDoctrine()->getManager();
             $em->persist($user);
             $em->flush();

            return $this->redirectToRoute('profile');
        }

        return $this->render('AppProjectBundle:Profile:show.html.twig', array('form' => $form->createView()));
    }

}

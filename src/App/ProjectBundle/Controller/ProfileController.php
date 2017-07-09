<?php

namespace App\ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use App\ProjectBundle\Entity\User;
use FOS\UserBundle\Controller\SecurityController;

class ProfileController extends Controller
{
    /**
     * @Route("/profile", name="profile")
     * @Template()
     */
    public function showAction(Request $request)
    {
     if( $this->get('security.context')->getToken() ){
         $token = $this->get('security.context')->getToken();
          die($token->getUser());
    } else {
        return $this->redirect('/login');
    }

        $form = $this->createFormBuilder($user)
            ->add('firstname', 'text', array('data' => 'Default value'))
            ->add('lastname', 'text')
            ->add('save', 'submit', array('label' => 'Update profile'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            $user = $form->getData();
            
           $repository = $this->getDoctrine()->getRepository('AppProjectBundle:User');
           $user = $repository->find(1);
           $user->setFirstname($form["firstname"]->getData());
           $user->setLastname($form["lastname"]->getData());
           
           $em = $this->getDoctrine()->getManager();
           $em->persist($user);
           $em->flush();
             
           die($user->getEmail());

            return $this->redirectToRoute('profile');
        }

        return $this->render('AppProjectBundle:Profile:show.html.twig', array('form' => $form->createView()));
    }
    
    /**
     * @Route("/updateprofile", name="profile_update")
     * @Template()
     */
    public function updateAction(Request $request) {
   die('rrrrr');
        
        $form->handleRequest($request);
        if ($request->isMethod('post')) {
            die('rrrrr');
            if ($form->isValid()) {
                
                  $this->get('session')->getFlashBag()->add('error', 'Form is not valid!');
//                $em = $this->getDoctrine()->getManager();
//                $user->upload();
//                $em->persist($user);
//                $em->flush();
//
//                return $this->redirect($this->generateUrl('profile_home'));
            } else {
                
                $this->get('session')->getFlashBag()->add('error', 'Form is not valid!');
                
            }
        }
        return array('form' => $form->createView());
    }

}

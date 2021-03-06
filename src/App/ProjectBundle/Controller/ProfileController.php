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
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $form = $this->createFormBuilder($user)
            ->add('username', 'text', array('data' => $user->getUsername()))
            ->add('email', 'text', array('data' => $user->getEmail()))
            ->add('save', 'submit', array('label' => 'Update profile', 'attr' => ['class' => 'btn btn_']))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             $user = $form->getData();
             $em = $this->getDoctrine()->getManager();
             $em->persist($user);
             $em->flush();

            $emailService = $this->get('email.service');

            $subject = 'Your profile was updated';
            $template = 'profile_changed';
            $params = array('username' => $user->getUsername());

            $emailService->sendMail($subject, $user->getEmail(), $template, $params);

            return $this->redirectToRoute('profile');
        }

        return $this->render('AppProjectBundle:Profile:show.html.twig', array('form' => $form->createView()));
    }

}

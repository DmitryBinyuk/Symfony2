<?php

namespace App\ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\ProjectBundle\Entity\Feedback;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\ProjectBundle\Form\Feedback as FeedbackForm;
use Symfony\Component\HttpFoundation\Request;

class FeedbackController extends Controller
{
    /**
     *@Route("/feedback", name="feedback")
     */
    public function getFeedbackForm(Request $request)
    {
        $feedback = new Feedback();

        $form = $this->createForm(new FeedbackForm(), $feedback);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $feedbackForm = $request->request->get('app_feedback');

            $feedback = new Feedback();
            $feedback->setTitle($feedbackForm['title']);
            $feedback->setBody($feedbackForm['title']);
            $feedback->setContactEmail($feedbackForm['contact_email']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($feedback);
            $em->flush();

            return $this->redirectToRoute('products');
        }

        return $this->render('AppProjectBundle:Feedback:show.html.twig', array('form' => $form->createView()));
    }
}

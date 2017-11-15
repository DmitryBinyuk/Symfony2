<?php

namespace App\ProjectBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;

class EmailService
{
    public function __construct()
    {

    }

    public function sendMail($subject, $receiver, $template, array $params)
    {
        $senderEmail = $this->container->getParameter('mailer_user');

        $message = (new \Swift_Message('Your profile was updated'))
            ->setFrom($senderEmail)
            ->setTo($receiver)
            ->setBody(
                $this->renderView(
                    'AppProjectBundle:Emails:'.$template.'.html.twig',
                    $params
                ),
                'text/html'
            );

        $this->get('mailer')->send($message);

        return [];

    }
}


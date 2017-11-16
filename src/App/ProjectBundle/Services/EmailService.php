<?php

namespace App\ProjectBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\Container;

class EmailService
{
    /**
     * @var Container
     */
    private $container;

    /**
     * The swift mailer
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * The twig parser
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * Constructor
     *
     * @param Container $container
     */
    public function __construct(
        Container $container,
        \Swift_Mailer $mailer,
        \Twig_Environment $twig = null)
    {
        $this->container = $container;
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendMail($subject, $receiver, $template, array $params)
    {
        $senderEmail = $this->container->getParameter('mailer_user');

        $message = (new \Swift_Message('Your profile was updated'))
            ->setFrom($senderEmail)
            ->setTo($receiver)
            ->setBody(
                $this->twig->render(
                    'AppProjectBundle:Emails:'.$template.'.html.twig',
                    $params
                ),
                'text/html'
            );

        $this->mailer->send($message);

        return [];
    }
}


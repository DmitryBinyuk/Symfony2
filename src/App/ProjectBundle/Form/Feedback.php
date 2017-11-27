<?php

namespace App\ProjectBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class Feedback extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('attr' => array('class' => 'form-control')))
            ->add('body', 'text', array('attr' => array('class' => 'form-control')))
            ->add('contact_email', 'email', array('attr' => array('class' => 'form-control')))
            ->add('save', 'submit', array('label' => 'Update',
                'attr' => array('class' => 'btn btn-success')))
        ;
    }

    public function getName()
    {
        return 'app_feedback';
    }
}
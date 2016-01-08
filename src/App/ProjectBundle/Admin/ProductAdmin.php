<?php

namespace App\ProjectBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ProductAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, array('required' => true, 'label' => 'Имя'))
            ->add('description', null, array('required' => false, 'label' => 'Описание'))
            ->add('price', null, array('required' => true, 'label' => 'Цена'))
            ->add('category', null, array('required' => true, 'label' => 'Категория'))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name', null, array('required' => true, 'label' => 'Имя'))
            ->add('description', null, array('required' => false, 'label' => 'Описание'))
            ->add('price', null, array('required' => true, 'label' => 'Цена'))
            ->add('category', null, array('required' => true, 'label' => 'Категория'))
            ->add('media', 'sonata_type_model_list', array(
                ), array(
                    'placeholder' => 'No media selected'
                ))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', null, array('required' => true, 'label' => 'Имя'))
            ->add('description', null, array('required' => false, 'label' => 'Описание'))
            ->add('price', null, array('required' => true, 'label' => 'Цена'))
//            ->add('category', 'sonata_type_model', array('label' => 'Категория', 'required' => false,
//    'multiple' => false))
            ->add('media', 'sonata_type_model_list', array(
                ), array(
                    'placeholder' => 'No media selected'
                ))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name', null, array('required' => true, 'label' => 'Имя'))
            ->add('description', null, array('required' => false, 'label' => 'Описание'))
            ->add('price', null, array('required' => true, 'label' => 'Цена'))
            ->add('category', null, array('required' => true, 'label' => 'Категория'))
        ;
    }
}

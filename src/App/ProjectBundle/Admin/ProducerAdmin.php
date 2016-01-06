<?php

namespace App\ProjectBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ProducerAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, array('required' => false, 'label' => 'Имя'))
            ->add('country', null, array('required' => false, 'label' => 'Страна'))
            ->add('description', null, array('required' => false, 'label' => 'Описание'))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name', null, array('required' => false, 'label' => 'Имя'))
            ->add('country', null, array('required' => false, 'label' => 'Страна'))
            ->add('description', null, array('required' => false, 'label' => 'Описание'))
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
            ->add('name', null, array('required' => false, 'label' => 'Имя'))
            ->add('country', null, array('required' => false, 'label' => 'Страна'))
            ->add('description', null, array('required' => false, 'label' => 'Описание'))
//            ->add('categories', 'sonata_type_model', array('multiple' => true))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name', null, array('required' => false, 'label' => 'Имя'))
            ->add('country', null, array('required' => false, 'label' => 'Страна'))
            ->add('description', null, array('required' => false, 'label' => 'Описание'))
        ;
    }
}

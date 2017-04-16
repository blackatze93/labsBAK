<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Equipo;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class EquipoAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombre', 'text')
            ->add('elementos', 'sonata_type_model', array(
                'class' => 'AppBundle\Entity\Elemento',
                'property' => 'nombre',
                'choices_as_values' => true,
                'multiple' => true,
            ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('nombre')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', 'text')
            ->add('nombre')
            ->add('_action', null, array(
                'label' => 'Acciones',
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }
//
//    public function configureShowFields(ShowMapper $showMapper)
//    {
//        $showMapper
//            ->add('id')
//            ->add('nombre')
//            ->add('dependencias', null, array(
//                'associated_property' => 'nombre',
//                'route' => array(
//                    'name' => 'show',
//                ),
//            ))
//            ->add('proyectosCurriculares', null, array(
//                'associated_property' => 'nombre',
//                'route' => array(
//                    'name' => 'show',
//                ),
//            ))
//        ;
//    }

    public function toString($object)
    {
        return $object instanceof Equipo
            ? $object->getNombre()
            : 'Equipo'; // shown in the breadcrumb on the create view
    }
}
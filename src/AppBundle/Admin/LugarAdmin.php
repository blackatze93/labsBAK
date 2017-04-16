<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Lugar;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class LugarAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombre')
            ->add('cantidadEquipos')
            ->add('descripcion')
            ->add('visible')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('nombre')
            ->add('cantidadEquipos')
            ->add('descripcion')
            ->add('visible')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', 'text')
            ->add('nombre')
            ->add('cantidadEquipos')
            ->add('descripcion')
            ->add('visible')
            ->add('_action', null, array(
                'label' => 'Acciones',
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                ),
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
        return $object instanceof Lugar
            ? $object->getNombre()
            : 'Lugar'; // shown in the breadcrumb on the create view
    }
}

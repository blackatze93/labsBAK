<?php

namespace AppBundle\Admin;

use AppBundle\Entity\ProyectoCurricular;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ProyectoCurricularAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('id', 'integer')
            ->add('nombre', 'text')
            ->add('facultad', 'sonata_type_model', array(
                'class' => 'AppBundle\Entity\Facultad',
                'property' => 'nombre',
            ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('nombre')
            ->add('facultad', null, array(), 'entity', array(
                'class' => 'AppBundle\Entity\Facultad',
                'property' => 'nombre',
            ))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', 'text')
            ->add('nombre')
            ->add('facultad', null, array(
                'route' => array(
                    'name' => 'show',
                ),
                'label' => 'Facultad',
                'associated_property' => 'nombre',
                'sortable' => true,
                'sort_field_mapping' => array(
                    'fieldName' => 'nombre',
                ),
                'sort_parent_association_mappings' => array(
                    array('fieldName' => 'facultad')
                )
            ))
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

    public function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('nombre')
            ->add('facultad', null, array(
                'associated_property' => 'nombre',
                'route' => array(
                    'name' => 'show',
                ),
            ))
        ;
    }

    public function toString($object)
    {
        return $object instanceof ProyectoCurricular
            ? $object->getNombre()
            : 'Proyecto Curricular'; // shown in the breadcrumb on the create view
    }
}
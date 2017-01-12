<?php

namespace AppBundle\Datatables;

use Sg\DatatablesBundle\Datatable\View\AbstractDatatableView;
use Sg\DatatablesBundle\Datatable\View\Style;

/**
 * Class UsuarioDatatable
 *
 * @package AppBundle\Datatables
 */
class UsuarioDatatable extends AbstractDatatableView
{
    /**
     * {@inheritdoc}
     */
    public function buildDatatable(array $options = array())
    {
        $this->topActions->set(array(
            'start_html' => '<div class="row"><div class="col-sm-12 text-right">',
            'end_html' => '<br><br></div></div>',
            'actions' => array(
                array(
                    'route' => $this->router->generate('usuario_new'),
                    'label' => 'Nuevo Usuario',
                    'icon' => 'glyphicon glyphicon-plus',
                    'attributes' => array(
                        'rel' => 'tooltip',
                        'title' => 'Nuevo Usuario',
                        'class' => 'btn btn-success',
                        'role' => 'button'
                    ),
                )
            )
        ));

        $this->features->set(array(
            'auto_width' => true,
            'defer_render' => false,
            'info' => true,
            'jquery_ui' => false,
            'length_change' => true,
            'ordering' => true,
            'paging' => true,
            'processing' => true,
            'scroll_x' => false,
            'scroll_y' => '',
            'searching' => true,
            'state_save' => false,
            'delay' => 0,
            'extensions' => array(),
            'highlight' => true,
            'highlight_color' => '#ffefc6'
        ));

        $this->ajax->set(array(
            'url' => $this->router->generate('usuario_results'),
            'type' => 'GET',
            'pipeline' => 0
        ));

        $this->options->set(array(
            'display_start' => 0,
            'defer_loading' => -1,
            'dom' => 'lfrtip',
            'length_menu' => array(10, 25, 50, 100, -1),
            'order_classes' => true,
            'order' => array(array(0, 'asc')),
            'order_multi' => true,
            'page_length' => 10,
            'paging_type' => Style::FULL_NUMBERS_PAGINATION,
            'renderer' => '',
            'scroll_collapse' => false,
            'search_delay' => 0,
            'state_duration' => 7200,
            'stripe_classes' => array(),
            'class' => Style::BOOTSTRAP_3_STYLE,
            'individual_filtering' => false,
            'individual_filtering_position' => 'head',
            'use_integration_options' => true,
            'force_dom' => false,
            'row_id' => 'id'
        ));

        $this->columnBuilder
            ->add('id', 'column', array(
                'title' => 'Id',
            ))
            ->add('nombre', 'column', array(
                'title' => 'Nombre',
                'editable' => true,
            ))
            ->add('apellido', 'column', array(
                'title' => 'Apellido',
                'editable' => true,
            ))
            ->add('email', 'column', array(
                'title' => 'Email',
            ))
            ->add('dependencia.nombre', 'column', array(
                'title' => 'Dependencia',
            ))
            ->add('funciones', 'column', array(
                'title' => 'Funciones',
                'editable' => true,
            ))
            ->add('estaActivo', 'boolean', array(
                'title' => 'Activo',
                'editable' => true,
            ))
            ->add('fechaAlta', 'timeago', array(
                'title' => 'Creado',
            ))
            ->add(null, 'action', array(
                'title' => $this->translator->trans('datatables.actions.title'),
                'actions' => array(
                    array(
                        'route' => 'usuario_show',
                        'route_parameters' => array(
                            'id' => 'id',
                        ),
                        'label' => $this->translator->trans('datatables.actions.show'),
                        'icon' => 'glyphicon glyphicon-eye-open',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('datatables.actions.show'),
                            'class' => 'btn btn-primary btn-sm btn-block',
                            'role' => 'button'
                        ),
                    ),
                    array(
                        'route' => 'usuario_edit',
                        'route_parameters' => array(
                            'id' => 'id'
                        ),
                        'label' => $this->translator->trans('datatables.actions.edit'),
                        'icon' => 'glyphicon glyphicon-edit',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('datatables.actions.edit'),
                            'class' => 'btn btn-warning btn-sm btn-block',
                            'role' => 'button'
                        ),
                    )
                )
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return 'AppBundle\Entity\Usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'usuario_datatable';
    }
}

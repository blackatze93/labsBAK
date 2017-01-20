<?php

namespace AppBundle\Datatables;

use Sg\DatatablesBundle\Datatable\View\AbstractDatatableView;
use Sg\DatatablesBundle\Datatable\View\Style;

/**
 * Class LugarDatatable.
 */
class LugarDatatable extends AbstractDatatableView
{
    /**
     * {@inheritdoc}
     */
    public function buildDatatable(array $options = array())
    {
        $this->topActions->set(array(
            'start_html' => '<div class="row"><div class="col-sm-12">',
            'end_html' => '</div></div><br>',
            'actions' => array(
                array(
                    'route' => $this->router->generate('lugar_new'),
                    'label' => 'Nuevo Lugar',
                    'icon' => 'glyphicon glyphicon-plus',
                    'attributes' => array(
                        'rel' => 'tooltip',
                        'title' => 'Nuevo Lugar',
                        'class' => 'btn btn-info',
                        'role' => 'button',
                    ),
                ),
            ),
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
            'extensions' => array(
                'buttons' => array(
                    'colvis' => array(
                        'text' => 'Columnas visibles',
                        'extend' => 'colvis',
                    ),
                    'excel' => array(
                        'extend' => 'excel',
                        'exportOptions' => array(
                            // show only the following columns:
                            'columns' => array(
                                '1',
                                '2',
                                '3',
                                '4',
                                '5',
                            ),
                        ),
                    ),
                    'pdf' => array(
                        'extend' => 'pdf',
                        'exportOptions' => array(
                            // show only the following columns:
                            'columns' => array(
                                '1',
                                '2',
                                '3',
                                '4',
                                '5',
                            ),
                        ),
                    ),
                ),
                'responsive' => true,
                'fixedHeader' => true,
            ),
            'highlight' => true,
            'highlight_color' => '#ffefc6',
        ));

        $this->ajax->set(array(
            'url' => $this->router->generate('lugar_results'),
            'type' => 'GET',
            'pipeline' => 0,
        ));

        $this->options->set(array(
            'display_start' => 0,
            'defer_loading' => -1,
            'dom' => "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>".
                "<'row'<'col-sm-12'tr>>".
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            'length_menu' => array(10, 25, 50, 100, -1),
            'order_classes' => true,
            'order' => array(array(1, 'asc')),
            'order_multi' => true,
            'page_length' => 10,
            'paging_type' => Style::FULL_NUMBERS_PAGINATION,
            'renderer' => '',
            'scroll_collapse' => false,
            'search_delay' => 0,
            'state_duration' => 7200,
            'stripe_classes' => array(),
            'class' => Style::BOOTSTRAP_3_STYLE,
            'individual_filtering' => true,
            'individual_filtering_position' => 'head',
            'use_integration_options' => true,
            'force_dom' => true,
            'row_id' => 'id',
        ));

        $this->columnBuilder
            ->add(null, 'multiselect', array(
                'actions' => array(
                    array(
                        'route' => 'lugar_bulk_show',
                        'label' => 'Mostrar',
                        'icon' => 'glyphicon glyphicon-plus',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => 'Mostrar',
                            'class' => 'btn btn-success btn-sm',
                            'role' => 'button',
                        ),
                    ),
                    array(
                        'route' => 'lugar_bulk_hide',
                        'label' => 'Ocultar',
                        'icon' => 'glyphicon glyphicon-minus',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => 'Ocultar',
                            'class' => 'btn btn-warning btn-sm',
                            'role' => 'button',
                        ),
                    ),
                    array(
                        'route' => 'lugar_bulk_delete',
                        'label' => 'Eliminar',
                        'icon' => 'glyphicon glyphicon-remove',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => 'Eliminar',
                            'class' => 'btn btn-danger btn-sm',
                            'role' => 'button',
                        ),
                    ),
                ),
            ))
            ->add('id', 'column', array(
                'title' => 'Id',
                'filter' => array('text', array(
                    'search_type' => 'like',
                )),
            ))
            ->add('nombre', 'column', array(
                'title' => 'Nombre',
                'filter' => array('text', array(
                    'search_type' => 'like',
                )),
            ))
            ->add('capacidad', 'column', array(
                'title' => 'Capacidad',
                'filter' => array('text', array(
                    'search_type' => 'like',
                )),
            ))
            ->add('visible', 'boolean', array(
                'title' => 'Visible',
                'filter' => array('select', array(
                    'search_type' => 'eq',
                    'select_options' => array('' => 'Todos', '1' => 'Si', '0' => 'No'),
                )),
            ))
            ->add('descripcion', 'column', array(
                'title' => 'Descripcion',
                'filter' => array('text', array(
                    'search_type' => 'like',
                )),
            ))
            ->add(null, 'action', array(
                'title' => $this->translator->trans('datatables.actions.title'),
                'actions' => array(
                    array(
                        'route' => 'lugar_show',
                        'route_parameters' => array(
                            'id' => 'id',
                        ),
                        'label' => $this->translator->trans('datatables.actions.show'),
                        'icon' => 'glyphicon glyphicon-eye-open',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('datatables.actions.show'),
                            'class' => 'btn btn-primary btn-xs',
                            'role' => 'button',
                        ),
                    ),
                    array(
                        'route' => 'lugar_edit',
                        'route_parameters' => array(
                            'id' => 'id',
                        ),
                        'label' => $this->translator->trans('datatables.actions.edit'),
                        'icon' => 'glyphicon glyphicon-edit',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('datatables.actions.edit'),
                            'class' => 'btn btn-warning btn-xs',
                            'role' => 'button',
                        ),
                    ),
                ),
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return 'AppBundle\Entity\Lugar';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'lugar_datatable';
    }
}

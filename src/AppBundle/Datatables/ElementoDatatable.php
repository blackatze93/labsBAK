<?php

namespace AppBundle\Datatables;

use Sg\DatatablesBundle\Datatable\View\AbstractDatatableView;
use Sg\DatatablesBundle\Datatable\View\Style;

/**
 * Class ElementoDatatable.
 */
class ElementoDatatable extends AbstractDatatableView
{
    /**
     * {@inheritdoc}
     */
    public function getLineFormatter()
    {
        $formatter = function ($line) {
            $rutaLugar = $this->router->generate('lugar_show', array('id' => $line['lugar']['id']));

            $line['lugar']['nombre'] = '<a href="'.$rutaLugar.'"></span> '.$line['lugar']['nombre'].'</a>';

            return $line;
        };

        return $formatter;
    }

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
                    'route' => $this->router->generate('elemento_new'),
                    'label' => 'Nuevo Elemento',
                    'icon' => 'glyphicon glyphicon-plus',
                    'attributes' => array(
                        'rel' => 'tooltip',
                        'title' => 'Nuevo Elemento',
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
                                '6',
                                '7',
                                '8',
                                '9',
                                '10',
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
                                '6',
                                '7',
                                '8',
                                '9',
                                '10',
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
            'url' => $this->router->generate('elemento_results'),
            'type' => 'GET',
            'pipeline' => 0,
        ));

        $this->options->set(array(
            'display_start' => 0,
            'defer_loading' => -1,
            'dom' => "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>".
                "<'row'<'col-sm-12'tr>>".
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            'length_menu' => array(50, 100, 500, -1),
            'order_classes' => true,
            'order' => array(array(1, 'asc')),
            'order_multi' => true,
            'page_length' => 50,
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

        $elemento = $this->em->getRepository('AppBundle:Elemento')->findAll();
        $lugar = $this->em->getRepository('AppBundle:Lugar')->findAll();

        $this->columnBuilder
            ->add(null, 'multiselect', array(
                'actions' => array(
                    array(
                        'route' => 'elemento_bulk_delete',
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
            ->add('marca', 'column', array(
                'title' => 'Marca',
                'filter' => array('text', array(
                    'search_type' => 'like',
                )),
            ))
            ->add('descripcion', 'column', array(
                'title' => 'Descripcion',
                'filter' => array('text', array(
                    'search_type' => 'like',
                )),
            ))
            ->add('serial', 'column', array(
                'title' => 'Serial',
                'filter' => array('text', array(
                    'search_type' => 'like',
                )),
            ))
            ->add('lugar.nombre', 'column', array(
                'title' => 'Lugar',
                'filter' => array('select', array(
                    'search_type' => 'eq',
                    'select_options' => array('' => 'Todos') + $this->getCollectionAsOptionsArray($lugar, 'nombre', 'nombre'),
                )),
            ))
            ->add('fechaIngreso', 'datetime', array(
                'title' => 'Fecha de Ingreso',
                'date_format' => 'll',
                'filter' => array('daterange', array()),
            ))
            ->add('tipo', 'column', array(
                'title' => 'Tipo',
                'filter' => array('select', array(
                    'search_type' => 'eq',
                    'select_options' => array('' => 'Todos') + $this->getCollectionAsOptionsArray($elemento, 'tipo', 'tipo'),
                )),
            ))
            ->add('tipoPrestamo', 'column', array(
                'title' => 'Tipo de Préstamo',
                'filter' => array('select', array(
                    'search_type' => 'eq',
                    'select_options' => array('' => 'Todos') + $this->getCollectionAsOptionsArray($elemento, 'tipoPrestamo', 'tipoPrestamo'),
                )),
            ))
            ->add('observaciones', 'column', array(
                'title' => 'Observaciones',
                'filter' => array('text', array(
                    'search_type' => 'like',
                )),
            ))
            ->add(null, 'action', array(
                'title' => $this->translator->trans('datatables.actions.title'),
                'actions' => array(
                    array(
                        'route' => 'elemento_show',
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
                        'route' => 'elemento_edit',
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
        return 'AppBundle\Entity\Elemento';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'elemento_datatable';
    }
}

<?php

namespace AppBundle\Datatables;

use Sg\DatatablesBundle\Datatable\View\AbstractDatatableView;
use Sg\DatatablesBundle\Datatable\View\Style;
use Symfony\Component\DependencyInjection\Container;

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
    public function getLineFormatter()
    {
        $formatter = function($line){
            $ruta_usuario = $this->router->generate('usuario_show', array('id' => $line['id']));
            $ruta_dependencia = $this->router->generate('dependencia_show', array('id' => $line['dependencia']['id']));


            $line['id'] = '<a href="' . $ruta_usuario . '"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> ' . $line['id'] . '</a>';
            $line['dependencia']['nombre'] = '<a href="' . $ruta_dependencia . '"></span> ' . $line['dependencia']['nombre'] . '</a>';
            $line['cargo'] = $this->translator->trans($line['cargo']);

            return $line;
        };

        return $formatter;
    }

    /**
     * {@inheritdoc}
     */
    public function buildDatatable(array $options = array())
    {
        // Acciones del encabezado de la tabla
        $this->topActions->set(array(
            'start_html' => '<div class="row"><div class="col-sm-6"><h3 class="encabezado">Lista de Usuarios</h3></div>' .
                            '<div class="col-sm-6 text-right">',
            'end_html' => '<br><br></div></div>',
            'actions' => array(
                array(
                    'route' => $this->router->generate('usuario_new'),
                    'label' => 'Nuevo Usuario',
                    'icon' => 'glyphicon glyphicon-plus',
                    'attributes' => array(
                        'rel' => 'tooltip',
                        'title' => 'Nuevo Usuario',
                        'class' => 'btn btn-info',
                        'role' => 'button'
                    ),
                )
            )
        ));

        // Opciones generales del bundle datatables
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
                'buttons' =>
                    array(
                        'colvis' => array(
                            'text' => 'Columnas visibles',
                            'extend' => 'colvis',
                            'columns' => array(
                                '2',
                                '3',
                                '4',
                                '5',
                                '6',
                                '7',
                                '8',
                                '9',
                            )
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
                                )
                            )
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
                                )
                            )
                        ),
                    ),
                'responsive' => true,
                'fixedHeader' => true,
            ),
            'highlight' => true,
            'highlight_color' => '#ffefc6'
        ));

        // Opciones ajax del datatable
        $this->ajax->set(array(
            'url' => $this->router->generate('usuario_results'),
            'type' => 'GET',
            'pipeline' => 0
        ));

        // Opciones generales de datatables
        $this->options->set(array(
            'display_start' => 0,
            'defer_loading' => -1,
            'dom' => "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" .
                "<'row'<'col-sm-12'tr>>" .
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
            'row_id' => 'id'
        ));

        // Campos necesarios para generar las listas de filtro
        $dependencia = $this->em->getRepository('AppBundle:Dependencia')->findAll();
        $usuario = $this->em->getRepository('AppBundle:Usuario')->findAll();

        // Columnas que se generan en la tabla
        $this->columnBuilder
            ->add(null, 'multiselect', array(
                'actions' => array(
                    array(
                        'route' => 'usuario_bulk_enable',
                        'label' => 'Activar',
                        'icon' => 'glyphicon glyphicon-plus',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => 'Activar',
                            'class' => 'btn btn-success',
                            'role' => 'button'
                        ),
                    ),
                    array(
                        'route' => 'usuario_bulk_disable',
                        'label' => 'Desactivar',
                        'icon' => 'glyphicon glyphicon-minus',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => 'Desactivar',
                            'class' => 'btn btn-warning',
                            'role' => 'button'
                        ),
                    ),
                    array(
                        'route' => 'usuario_bulk_delete',
                        'label' => 'Eliminar',
                        'icon' => 'glyphicon glyphicon-remove',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => 'Eliminar',
                            'class' => 'btn btn-danger',
                            'role' => 'button'
                        ),
                    ),
                )
            ))
            ->add('id', 'column', array(
                'title' => 'Id',
                'filter' => array('text', array(
                    'search_type' => 'like',
                ))
            ))
            ->add('nombre', 'column', array(
                'title' => 'Nombre',
                'filter' => array('text', array(
                    'search_type' => 'like',
                ))
            ))
            ->add('apellido', 'column', array(
                'title' => 'Apellido',
                'filter' => array('text', array(
                    'search_type' => 'like',
                ))
            ))
            ->add('email', 'column', array(
                'title' => 'Email',
                'filter' => array('text', array(
                    'search_type' => 'like',
                ))
            ))
            ->add('dependencia.nombre', 'column', array(
                'title' => 'Dependencia',
                'filter' => array('select', array(
                    'search_type' => 'eq',
                    'select_options' => array('' => 'Todos') + $this->getCollectionAsOptionsArray($dependencia, 'nombre', 'nombre'),
                ))
            ))
            ->add('cargo', 'column', array(
                'title' => 'Cargo',
                'filter' => array('select', array(
                    'search_type' => 'eq',
                    'select_options' => array('' => 'Todos') + $this->getListaCargos($usuario, 'cargo', 'cargo'),
                ))
            ))
            ->add('funciones', 'column', array(
                'title' => 'Funciones',
                'filter' => array('text', array(
                    'search_type' => 'like',
                ))
            ))
            ->add('estaActivo', 'boolean', array(
                'title' => 'Activo',
                'filter' => array('select', array(
                    'search_type' => 'eq',
                    'select_options' => array('' => 'Todos', '1' => 'Si', '0' => 'No'),
                ))
            ))
            ->add('fechaAlta', 'datetime', array(
                'title' => 'Fecha Alta',
                'filter' => array('daterange', array()),
            ))
        ;
    }

    /**
     * Obtiene un array con los elementos traducidos para el campo cargo
     *
     * @param ArrayCollection $entitiesCollection
     * @param string          $keyPropertyName
     * @param string          $valuePropertyName
     *
     * @return array
     */
    public function getListaCargos($entitiesCollection, $keyPropertyName = 'id', $valuePropertyName = 'name')
    {
        $options = array();

        foreach ($entitiesCollection as $entity) {
            $keyPropertyName = Container::camelize($keyPropertyName);
            $keyGetter = 'get' . ucfirst($keyPropertyName);
            $valuePropertyName = Container::camelize($valuePropertyName);
            $valueGetter = 'get' . ucfirst($valuePropertyName);
            $options[$entity->$keyGetter()] = $this->translator->trans($entity->$valueGetter());
        }

        return $options;
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

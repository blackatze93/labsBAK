<?php

namespace AppBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ElementoController.
 */
class ElementoController extends BaseAdminController
{
    /**
     * @return JsonResponse
     */
    protected function autocompleteAction()
    {
        $referer = $this->request->headers->get('referer');
        $isPrestamo = strpos($referer, 'PrestamoElemento');
        $isEquipo = strpos($referer, 'Equipo');
        $dqlFilter = null;

        if ($isPrestamo) {
            $dqlFilter = 'entity.activo = true and entity.prestado = false and entity.tipoPrestamo != \'Nadie\'';
        } elseif ($isEquipo) {
            $dqlFilter = 'entity.activo = true';
        } else {
            $dqlFilter = 'entity.activo = true and entity.prestado = false';
        }

        $results = $this->get('easyadmin.autocomplete')->find(
            $this->request->query->get('entity'),
            $this->request->query->get('query'),
            $this->request->query->get('page', 1),
            $dqlFilter
        );

        return new JsonResponse($results);
    }
}

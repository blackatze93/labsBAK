<?php

namespace AppBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class EquipoController.
 */
class EquipoController extends BaseAdminController
{
    /**
     * @return JsonResponse
     */
    protected function autocompleteAction()
    {
        $referer = $this->request->headers->get('referer');
        $isPrestamo = strpos($referer, 'PrestamoPracticaLibre');
        $dqlFilter = null;

        if ($isPrestamo) {
            $dqlFilter = 'entity.prestado = false';
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

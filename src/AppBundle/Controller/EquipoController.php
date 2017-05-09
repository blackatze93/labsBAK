<?php

namespace AppBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class EquipoController.
 */
class EquipoController extends BaseAdminController
{
    protected function autocompleteAction()
    {
        $results = $this->get('easyadmin.autocomplete')->find(
            $this->request->query->get('entity'),
            $this->request->query->get('query'),
            $this->request->query->get('page', 1),
            'entity.prestado = false'
        );

        return new JsonResponse($results);
    }
}

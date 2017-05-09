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
        $results = $this->get('easyadmin.autocomplete')->find(
            $this->request->query->get('entity'),
            $this->request->query->get('query'),
            $this->request->query->get('page', 1),
            'entity.activo = true'
        );

        return new JsonResponse($results);
    }
}

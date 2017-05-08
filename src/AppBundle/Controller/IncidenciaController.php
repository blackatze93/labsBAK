<?php

namespace AppBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

/**
 * Class IncidenciaController.
 */
class IncidenciaController extends BaseAdminController
{
    /**
     * @param object $entity
     */
    protected function prePersistEntity($entity)
    {
        $usuario = $this->getUser();
        $entity->setUsuarioRegistra($usuario);
    }

    /**
     * @param object $entity
     */
    protected function preUpdateEntity($entity)
    {
        $usuario = $this->getUser();
        $entity->setUsuarioRegistra($usuario);
    }
}

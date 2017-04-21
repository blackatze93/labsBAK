<?php

namespace AppBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

/**
 * Class EventoController.
 */
class EventoController extends BaseAdminController
{
    protected function prePersistEntity($entity)
    {
        $usuario = $this->getUser();
        $entity->setUsuario($usuario);
    }
}

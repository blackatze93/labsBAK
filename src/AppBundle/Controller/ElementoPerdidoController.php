<?php

namespace AppBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

/**
 * Class ElementoPerdidoController.
 */
class ElementoPerdidoController extends BaseAdminController
{
    protected function prePersistEntity($entity)
    {
        $usuario = $this->getUser();
        $entity->setUsuarioRegistra($usuario);

        if ($entity->isEntregado()) {
            $entity->setUsuarioEntrega($usuario);
            $entity->setFechaEntrega(new \DateTime());
        }
    }

    protected function preUpdateEntity($entity)
    {
        $usuario = $this->getUser();

        if ($entity->isEntregado()) {
            $entity->setUsuarioEntrega($usuario);
            $entity->setFechaEntrega(new \DateTime());
        }
    }
}

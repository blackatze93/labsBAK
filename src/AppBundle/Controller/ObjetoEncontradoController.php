<?php

namespace AppBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

/**
 * Class ObjetoEncontradoController.
 */
class ObjetoEncontradoController extends BaseAdminController
{
    /**
     * @param object $entity
     */
    protected function prePersistEntity($entity)
    {
        $usuario = $this->getUser();
        $entity->setUsuarioRegistra($usuario);

        if ($entity->getEstado() === 'Entregado' || $entity->getUsuarioReclama()) {
            $entity->setUsuarioEntrega($usuario);
            $entity->setFechaEntrega(new \DateTime());
        }
    }

    /**
     * @param object $entity
     */
    protected function preUpdateEntity($entity)
    {
        $usuario = $this->getUser();

        if ($entity->getEstado() === 'Entregado' || $entity->getUsuarioReclama()) {
            $entity->setUsuarioEntrega($usuario);
            $entity->setFechaEntrega(new \DateTime());
        }
    }
}

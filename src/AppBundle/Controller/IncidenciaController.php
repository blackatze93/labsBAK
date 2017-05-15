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

        $entity->setFechaRegistro(new \DateTime());

        $entity->setEstado('Pendiente');
    }

    /**
     * @param object $entity
     */
    protected function preUpdateEntity($entity)
    {
        $usuario = $this->getUser();

        if ($entity->getEstado() == 'Atendida') {
            $entity->setUsuarioAtiende($usuario);
            $entity->setFechaAtencion(new \DateTime());
        }
    }
}

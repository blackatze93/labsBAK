<?php

namespace AppBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

/**
 * Class SoporteFacultadController.
 */
class SoporteFacultadController extends BaseAdminController
{
    /**
     * @param object $entity
     */
    protected function prePersistEntity($entity)
    {
        $usuario = $this->getUser();
        $entity->setUsuarioRegistra($usuario);

        $entity->setFechaRegistro(new \DateTime());
    }
}

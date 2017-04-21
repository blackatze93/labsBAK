<?php

namespace AppBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

/**
 * Class DocumentoController.
 */
class DocumentoController extends BaseAdminController
{
    protected function prePersistEntity($entity)
    {
        $usuario = $this->getUser();
        $entity->setUsuario($usuario);
    }

    protected function preUpdateEntity($entity)
    {
        $usuario = $this->getUser();
        $entity->setUsuario($usuario);
    }
}

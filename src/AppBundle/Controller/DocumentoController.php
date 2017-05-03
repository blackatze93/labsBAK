<?php

namespace AppBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

/**
 * Class DocumentoController.
 */
class DocumentoController extends BaseAdminController
{
    /**
     * @param object $entity
     */
    protected function prePersistEntity($entity)
    {
        $usuario = $this->getUser();
        $entity->setUsuarioSube($usuario);
    }

    /**
     * @param object $entity
     */
    protected function preUpdateEntity($entity)
    {
        $usuario = $this->getUser();
        $entity->setUsuarioSube($usuario);
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PrestamoPracticaLibre;
use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

/**
 * Class PrestamoPracticaLibreController.
 */
class PrestamoPracticaLibreController extends BaseAdminController
{
    /**
     * @param object $entity
     */
    protected function prePersistEntity($entity)
    {
        $usuario = $this->getUser();
        $entity->setUsuarioRealiza($usuario);

        if (!$entity->getHoraSalida()) {
            $entity->getEquipo()->setPrestado(true);
        } else {
            $entity->getEquipo()->setPrestado(false);
        }
    }

    protected function preUpdateEntity($entity)
    {
        if (!$entity->getHoraSalida()) {
            $entity->getEquipo()->setPrestado(true);
        } else {
            $entity->getEquipo()->setPrestado(false);
        }
    }
}
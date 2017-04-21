<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ElementoPerdido;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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

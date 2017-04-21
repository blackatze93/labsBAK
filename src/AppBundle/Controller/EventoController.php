<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Evento;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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

<?php

namespace AppBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JavierEguiluz\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * Metodo que lista los objetos encontrados en el sitio web.
     *
     * @Route("/objetos_encontrados/", name="objetos_encontrados")
     */
    public function objetosEncontradosAction()
    {
        $em = $this->getDoctrine()->getManager();

        $objetos = $em->getRepository('AppBundle:ObjetoEncontrado')->findBy(
            array('estado' => 'Disponible'),
            array('fechaRegistro' => 'DESC')
        );

        return $this->render('objetos_encontrados.html.twig', array(
            'objetos' => $objetos
        ));
    }
}

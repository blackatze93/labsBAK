<?php

namespace AppBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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

        if ($entity->isEntregado() || $entity->getUsuarioReclama()) {
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

        if ($entity->isEntregado() || $entity->getUsuarioReclama()) {
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
            array('entregado' => false),
            array('fechaRegistro' => 'DESC')
        );

        return $this->render('objetos_encontrados.html.twig', array(
            'objetos' => $objetos,
        ));
    }
}

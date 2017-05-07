<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Equipo;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

/**
 * Lugar controller.
 */
class LugarController extends BaseAdminController
{
    protected function prePersistEntity($entity)
    {
        $cantidadEquipos = $entity->getCantidadEquipos();
        $idSala = $entity->getId();

        for ($i = 0; $i < $cantidadEquipos; ++$i) {
            $equipo = new Equipo();

            $equipo->setNombre('FT'.$idSala.'_0'.($i+2));
            $equipo->setLugar($entity);

            $this->em->persist($equipo);
        }
    }


    /**
     * Return a Response with the resources of the calendar.
     *
     * @return Response
     *
     * @internal param Request $request
     *
     * @Route("/fc-load-lugares/", name="fullcalendar_lugares", options={"expose"=true})
     * @Method("POST")
     */
    public function cargarLugaresAction()
    {
        $em = $this->getDoctrine()->getManager();
        $lugares = $em->getRepository('AppBundle:Lugar')->findAllVisibles();

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $returnLugares = array();

        foreach ($lugares as $lugar) {
            $returnLugares[] = $lugar->toArray();
        }

        $response->setContent(json_encode($returnLugares));

        return $response;
    }
}

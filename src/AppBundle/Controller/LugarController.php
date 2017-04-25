<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Lugar controller.
 *
 * @Route("lugar")
 */
class LugarController extends Controller
{
    /**
     * Return a Response with the resources of the calendar.
     *
     * @return Response
     *
     * @internal param Request $request
     *
     * @Route("/fc-load-lugares", name="fullcalendar_lugares", options={"expose"=true})
     * @Method("POST")
     */
    public function cargarLugaresAction()
    {
        $em = $this->getDoctrine()->getManager();
        $lugares = $em->getRepository('AppBundle:Lugar')->findAllVisibles();

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $return_lugares = array();

        foreach ($lugares as $lugar) {
            $return_lugares[] = $lugar->toArray();
        }

        $response->setContent(json_encode($return_lugares));

        return $response;
    }
}

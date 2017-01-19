<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController.
 */
class DefaultController extends Controller
{
    /**
     * Metodo que genera la pagina principal del sitio web.
     *
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        return $this->render('index.html.twig');
    }


    /**
     * Return a Response with the resources of the calendar
     *
     * @param Request $request
     *
     * @Route("/fc-load-lugares", name="fullcalendar_lugares", options={"expose"=true})
     * @Method("POST")
     *
     * @return Response
     */
    public function cargarLugaresAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $lugares = $em->getRepository('AppBundle:Lugar')->finAllVisibles();

        $response = new \Symfony\Component\HttpFoundation\Response();
        $response->headers->set('Content-Type', 'application/json');

        $return_lugares = array();

        foreach($lugares as $lugar) {
            $return_lugares[] = $lugar->toArray();
        }

        $response->setContent(json_encode($return_lugares));

        return $response;
    }

}
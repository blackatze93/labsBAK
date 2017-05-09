<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class GraficoController.
 *
 * * @Route("/admin/graficos/")
 */
class GraficoController extends Controller
{
    /**
     * Metodo que genera el paz y salvo.
     *
     * @Route("prueba/", name="prueba")
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param Request $request
     */
    public function pruebaAction()
    {
        return $this->render(':graficos:prueba.html.twig');
    }
}

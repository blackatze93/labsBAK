<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;

class ReporteController extends Controller
{
    /**
     * Metodo que genera el paz y salvo.
     *
     * @Route("/admin/paz_y_salvo", name="paz_y_salvo")
     */
    public function pazSalvoAction()
    {
//        $mpdfService = $this->get('tfox.mpdfport');
//        $html = "Hello World!";
//        $response = $mpdfService->generatePdfResponse($html);
//
//        return $response;

        return $this->render(':reportes:paz_y_salvo.html.twig');
    }
}

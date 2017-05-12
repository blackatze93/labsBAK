<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Ob\HighchartsBundle\Highcharts\Highchart;
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
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @internal param Request $request
     */
    public function pruebaAction()
    {
        $em = $this->getDoctrine()->getManager();
        $prestamos = $em->getRepository('AppBundle:PrestamoPracticaLibre')
            ->createQueryBuilder('prestamos')
            ->select('MONTH(prestamos.fechaPrestamo) AS fechaPrestamo')
            ->groupBy('fechaPrestamo')
            ->getQuery()
            ->getResult();

        var_dump($prestamos);

        // Chart
        $series = array(
            array(
                "name" => "Data Serie Name",
                "data" => $prestamos
//                "data" => array(
////                    1,2,4,5,6,3,8
////                    array(
////                        "color" => '#545454',
////                        "y" => 5
////                    )
//                ),
            )
        );

        $ob = new Highchart();
        $ob->chart->renderTo('container');  // The #id of the div where to render the chart
        $ob->title->text('Prestamos Practica Libre');
        $ob->chart->type('column');
        $ob->xAxis->title(array('text'  => "Mes"));
        $ob->yAxis->title(array('text'  => "Cantidad"));
        $ob->series($series);

        return $this->render(':graficos:prueba.html.twig', array(
            'chart' => $ob
        ));
    }
}

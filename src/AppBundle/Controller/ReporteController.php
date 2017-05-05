<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class ReporteController.
 * 
 * @Route("/admin/reportes/")
 */
class ReporteController extends Controller
{
    /**
     * Metodo que genera el paz y salvo.
     *
     * @Route("paz_y_salvo/", name="paz_y_salvo")
     */
    public function pazSalvoAction(Request $request)
    {
        // Se genera el formulario que permite crear el paz y salvo
        $form = $this->createFormBuilder()
            ->add('usuario', 'easyadmin_autocomplete', array(
                'class' => 'AppBundle\Entity\Usuario',
                'constraints' => new NotBlank(),
            ))
            ->add('consultar', 'submit')
            ->add('generar', 'submit')
            ->getForm()
        ;

        // Dejamos que symfony maneje el Request
        $form->handleRequest($request);

        // Si el formulario se ha enviado y es valido comprobamos el usuario
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $pazSalvo = 'no';

            // Usamos una variable bandera para saber si el usuario esta en paz y salvo
            if ($data['usuario']->getEstado() == 'Paz y Salvo') {
                $pazSalvo = 'si';
            }

            // Si la opcion que selecciono fue generar y el usuario esta en paz y salvo procedemos a generarlo
            if ($form->get('generar')->isClicked() && $pazSalvo == 'si') {
                $mpdfService = $this->get('tfox.mpdfport');
                $mPDF = $mpdfService->getMpdf();
                $fecha = new \DateTime();

                $html = '
                <!DOCTYPE html>
                <html>
                    <head>
                        <title>FORMATO DE PAZ Y SALVOS</title>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <link rel="stylesheet" type="text/css" href="ESTILOSFORMATOS2.css" media="all">
                    </head>
                    <body>
                    <table class="encabezado">
                        <tr>
                            <td class="ESySI" rowspan="3"><img src="escudo.png" alt="" style="width: 90%; height: 90%;"></td>
                            <td class="soliBaja">FORMATO DE PAZ Y SALVO</td>
                            <td class="Cod">Código:</td>
                            <td class="ESySI" rowspan="3"><img src="sigud.png" alt="" style="width: 90%; height: 90%;"></td>
                        </tr>
                        <tr>
                            <td class="MP">Macro proceso: Apoyo a lo misional</td>
                            <td class="Cod">Versión: </td>
                        </tr>
                        <tr>
                            <td class="PG">Proceso: Gestión de Laboratorios de Informática</td>
                            <td class="PG">Fecha de aprobación: ___/___/_____ </td>
                        </tr>
                    </table> 
                    <br><br>
                    <p align="justify">Los Laboratorios de Informática de la Facultad Tecnológica, hacen constar que el (la) 
                        estudiante '.$data['usuario']->getNombre().' '.$data['usuario']->getApellido().' con documento de identificación número: '
                        .$data['usuario']->getDocumento().' y código estudiantil: '.$data['usuario']->getCodigo().', del proyecto curricular '
                        .$data['usuario']->getProyectoCurricular().' se encuentra a paz y salvo por todo concepto en el mencionado laboratorio.
                        <br><br><br>El presente certificado se expide por solicitud del interesado a los '
                        .$fecha->format('d').' día(s) del mes '.$fecha->format('m').' de '.$fecha->format('Y')
                        .'.<br><br><br><br><br>
                        Atentamente,<br><br><br><br><br>
            
                        _____________________________<br>
                        <b>ING. JOSE VICENTE REYES MOZO</b><br>
                        Coordinador Laboratorios de Informática<br>
                        Universidad Distrital Francisco José de Caldas<br>
                        Facultad Tecnológica<br>
                    </p>
                </body>
                </html>
                ';
                $arguments = array(
                    'SetHeader' => 'gato'
//                    'constructorArgs' => array(), //Constructor arguments. Numeric array. Don't forget about points 2 and 3 in Warning section!
//                    'writeHtmlMode' => null, //$mode argument for WriteHTML method
//                    'writeHtmlInitialise' => null, //$mode argument for WriteHTML method
//                    'writeHtmlClose' => null, //$close argument for WriteHTML method
//                    'outputFilename' => 'paz_y.pdf', //$filename argument for Output method
//                    'outputDest' => 'D' //$dest argument for Output method
                );
                $response = $mpdfService->generatePdfResponse($html, $arguments);

                return $response;
            }

            return $this->render(':reportes:paz_y_salvo.html.twig', array(
                'form' => $form->createView(),
                'pazSalvo' => $pazSalvo,
            ));
        }

        return $this->render(':reportes:paz_y_salvo.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}


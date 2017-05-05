<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use Doctrine\ORM\Mapping\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;

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
     */
    public function pruebaAction(Request $request)
    {
//        $mpdfService = $this->get('tfox.mpdfport');
//        $html = "Hello World!";
//        $response = $mpdfService->generatePdfResponse($html);
//
//        return $response;
        // $form = $this->createFormBuilder()
        //     ->add('usuario', 'easyadmin_autocomplete', array(
        //         'class' => 'AppBundle\Entity\Usuario',
        //         'constraints' => new NotBlank(),
        //     ))

        //     ->getForm();

        // // TODO: agregar boton de enviar y manejar el envio del mismo
        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $data = $form->getData();
        // }

        return $this->render(':graficos:prueba.html.twig');
    }
}

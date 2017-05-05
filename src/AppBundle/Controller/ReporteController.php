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
//        $mpdfService = $this->get('tfox.mpdfport');
//        $html = "Hello World!";
//        $response = $mpdfService->generatePdfResponse($html);
//
//        return $response;
        $form = $this->createFormBuilder()
            ->add('usuario', 'easyadmin_autocomplete', array(
                'class' => 'AppBundle\Entity\Usuario',
                'constraints' => new NotBlank(),
            ))
            ->add('consultar', 'submit')

            ->getForm();
            
        // TODO: agregar boton de enviar y manejar el envio del mismo
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
        }

        return $this->render(':reportes:paz_y_salvo.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}

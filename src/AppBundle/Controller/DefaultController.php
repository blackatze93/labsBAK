<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

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
     * Metodo que lista los objetos encontrados en el sitio web.
     *
     * @Route("/solicitud_sala/", name="solicitud_sala")
     */
    public function solicitudSalaAction()
    {
        return $this->render('solicitud_sala.html.twig');
    }

    /**
     * Metodo que lista los objetos encontrados en el sitio web.
     *
     * @Route("/elementos_prestamo/", name="elementos_prestamo")
     */
    public function elementosPrestamoAction()
    {
        return $this->render('elementos_prestamo.html.twig');
    }

    /**
     * Metodo que lista los objetos encontrados en el sitio web.
     *
     * @Route("/objetos_encontrados/", name="objetos_encontrados")
     */
    public function objetosEncontradosAction()
    {
        return $this->render('objetos_encontrados.html.twig');
    }

    /**
     * Metodo que genera el calendario
     *
     * @Route("/calendario/", name="calendario")
     */
    public function calendarioAction()
    {
        return $this->render('calendario.html.twig');
    }

    /**
     * Metodo que genera el paz y salvo
     *
     * @Route("/paz_y_salvo/", name="paz_y_salvo")
     */
    public function pazYSalvoAction(Request $request)
    {
        // Se genera el formulario que permite crear el paz y salvo
        $form = $this->createFormBuilder()
            ->add('codigo', 'integer', array(
                'constraints' => array(
                    new NotBlank(),
                    new Type('integer'),
                    new Range(array('min' => 1)),
                )
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

            $em = $this->getDoctrine()->getManager();
            $usuario = $em->getRepository('AppBundle:Usuario')->findOneBy(array('codigo' => $data['codigo']));

            if ($usuario) {
                $pazSalvo = 'no';

                // Usamos una variable bandera para saber si el usuario esta en paz y salvo
                if ($usuario->getEstado() == 'Paz y Salvo' && $usuario->isActivo()) {
                    $pazSalvo = 'si';
                }

                // Si la opcion que selecciono fue generar y el usuario esta en paz y salvo procedemos a generarlo
                if ($form->get('generar')->isClicked() && $pazSalvo == 'si') {
                    $reporte = new ReporteController();

                    return $reporte->crearPdf($usuario, $this->get('tfox.mpdfport'), $this->container->get('templating.helper.assets'));
                }
            } else {
                $pazSalvo = 'no_registrado';
            }

            return $this->render('paz_y_salvo.html.twig', array(
                'form' => $form->createView(),
                'pazSalvo' => $pazSalvo,
            ));
        }

        return $this->render('paz_y_salvo.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\SolicitudPrestamoSala;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

/**
 * Class SolicitudPrestamoSalaController.
 */
class SolicitudPrestamoSalaController extends Controller
{
    /**
     * Metodo que lista los objetos encontrados en el sitio web.
     *
     * @Security("has_role('ROLE_DOCENTE') or has_role('ROLE_FUNCIONARIO')")
     * @Route("/solicitud_sala/", name="solicitud_sala")
     */
    public function solicitudSalaAction(Request $request)
    {
        $solicitudSala = new SolicitudPrestamoSala();

        $solicitudSala->setFechaSolicitud(new \DateTime());
        $solicitudSala->setUsuarioRealiza($this->getUser());

        // Se genera el formulario que permite crear el paz y salvo
        $form = $this->createFormBuilder($solicitudSala)
            ->add('fecha', DateTimeType::class, array(
                'widget' => 'single_text',
                'html5' => false
            ))
            ->add('observaciones', CKEditorType::class)
            ->add('crear', SubmitType::class)
            ->add('restablecer', ResetType::class)
            ->getForm()
        ;

//        // Dejamos que symfony maneje el Request
//        $form->handleRequest($request);
//
//        // Si el formulario se ha enviado y es valido comprobamos el usuario
//        if ($form->isSubmitted() && $form->isValid()) {
//            $data = $form->getData();
//
//            $em = $this->getDoctrine()->getManager();
//            $usuario = $em->getRepository('AppBundle:Usuario')->findOneBy(array('codigo' => $data['codigo']));
//
//            if ($usuario) {
//                $pazSalvo = 'no';
//
//                // Usamos una variable bandera para saber si el usuario esta en paz y salvo
//                if ($usuario->getEstado() == 'Paz y Salvo' && $usuario->isActivo()) {
//                    $pazSalvo = 'si';
//                }
//
//                // Si la opcion que selecciono fue generar y el usuario esta en paz y salvo procedemos a generarlo
//                if ($form->get('generar')->isClicked() && $pazSalvo == 'si') {
//                    $reporte = new ReporteController();
//
//                    return $reporte->crearPazSalvo($usuario, $this->get('tfox.mpdfport'), $this->container->get('templating.helper.assets'));
//                }
//            } else {
//                $pazSalvo = 'no_registrado';
//            }
//
//            return $this->render('solicitud_sala.html.twig', array(
//                'form' => $form->createView(),
//                'pazSalvo' => $pazSalvo,
//            ));
//        }

        return $this->render('solicitud_sala.html.twig', array(
            'form' => $form->createView()
        ));
    }
}

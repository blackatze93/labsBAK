<?php

namespace AppBundle\Controller;

use AppBundle\Entity\SolicitudSala;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

/**
 * Class SolicitudSalaController.
 */
class SolicitudSalaController extends BaseAdminController
{
    //     * @Security("has_role('ROLE_DOCENTE') or has_role('ROLE_FUNCIONARIO')")

    /**
     * Metodo que lista los objetos encontrados en el sitio web.
     *
     * @Route("/solicitud_sala/", name="solicitud_sala")
     */
    public function solicitudSalaAction(Request $request)
    {
        $solicitudSala = new SolicitudSala();

        // Se genera el formulario que permite crear el paz y salvo
        $form = $this->createFormBuilder($solicitudSala)
            ->add('fecha', DateType::class, array(
                'widget' => 'single_text',
                'html5' => false
            ))
            ->add('horaInicio', TimeType::class, array(
                'widget' => 'single_text',
                'html5' => false
            ))
            ->add('horaFin', TimeType::class, array(
                'widget' => 'single_text',
                'html5' => false
            ))
            ->add('lugar', 'easyadmin_autocomplete', array(
                'class' => 'AppBundle\Entity\Lugar'
            ))
            ->add('observaciones', CKEditorType::class)
            ->add('crear', SubmitType::class)
            ->add('restablecer', ResetType::class)
            ->getForm()
        ;

        // Dejamos que symfony maneje el Request
        $form->handleRequest($request);

        // Si el formulario se ha enviado y es valido comprobamos el usuario
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $solicitudSala = $form->getData();

            $solicitudSala->setFechaSolicitud(new \DateTime());
            $solicitudSala->setUsuarioRealiza($this->getUser());
            $solicitudSala->setEstado('Pendiente');

            $em->persist($solicitudSala);
            $em->flush();

            return $this->render('solicitud_sala.html.twig', array(
                'form' => $form->createView(),
            ));
        }

        return $this->render('solicitud_sala.html.twig', array(
            'form' => $form->createView()
        ));
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\SolicitudSoftware;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Doctrine\ORM\EntityRepository;

/**
 * Class SolicitudSoftwareController.
 */
class SolicitudSoftwareController extends BaseAdminController
{
    /**
     * @param object $entity
     */
    protected function preUpdateEntity($entity)
    {
        if ($entity->getEstado() == 'Aprobada') {
            $entity->setFechaRespuesta(new \DateTime());
            $entity->setUsuarioResponde($this->getUser());
        }
    }

    /**
     * Metodo que lista los objetos encontrados en el sitio web.
     *
     * @Security("has_role('ROLE_DOCENTE') or has_role('ROLE_FUNCIONARIO')")
     * @Route("/solicitud_software/", name="solicitud_software")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function solicitudSoftwareAction(Request $request)
    {
        $solicitudSoftware = new SolicitudSoftware();

        // Se genera el formulario que permite crear el paz y salvo
        $form = $this->createFormBuilder($solicitudSoftware)
            ->add('nombre')
            ->add('lugar', EntityType::class, array(
                'class' => 'AppBundle\Entity\Lugar',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('lugar')
                        ->where('lugar.visible = true');
                },
                'attr' => array(
                    'data-widget' => 'select2',
                ),
            ))
            ->add('observaciones', CKEditorType::class, array(
                'required' => false,
            ))
            ->add('crear', SubmitType::class)
            ->add('restablecer', ResetType::class)
            ->getForm()
        ;

        // Dejamos que symfony maneje el Request
        $form->handleRequest($request);

        // Si el formulario se ha enviado y es valido comprobamos el usuario
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $solicitudSoftware = $form->getData();

            $solicitudSoftware->setFechaSolicitud(new \DateTime());
            $solicitudSoftware->setUsuarioRealiza($this->getUser());
            $solicitudSoftware->setEstado('Pendiente');

            $em->persist($solicitudSoftware);

            try {
                $em->flush();
                $this->addFlash('success', 'Se registró su solicitud correctamente');

                return $this->redirectToRoute('index');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se pudo registrar su solicitud');
            }
        }

        return $this->render('solicitud_software.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}

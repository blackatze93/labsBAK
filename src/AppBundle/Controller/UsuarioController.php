<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class UsuarioController.
 */
class UsuarioController extends BaseAdminController
{
    /**
     * @param object $entity
     */
    protected function prePersistEntity($entity)
    {
        // Se obtiene el encoder, que es el metodo de encriptacion de la entidad usuario
        $encoder = $this->get('security.encoder_factory')->getEncoder($entity);
        // Se codifica el password mediante el encoder
        $passwordCodificado = $encoder->encodePassword($entity->getPasswordEnClaro(), null);
        // Se establece el password en la entidad mediante el medoto setPassword
        $entity->setPassword($passwordCodificado);
    }

    /**
     * @param object $entity
     */
    protected function preUpdateEntity($entity)
    {
        if ($entity->getPasswordEnClaro() !== null) {
            $encoder = $this->get('security.encoder_factory')->getEncoder($entity);
            $passwordCodificado = $encoder->encodePassword($entity->getPasswordEnClaro(), null);
            $entity->setPassword($passwordCodificado);
        }
    }

    /**
     * Metodo que permite ver el perfil de un usuario y modificarlo.
     *
     * @Route("/perfil/", name="usuario_perfil")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function perfilAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') || $this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
            $this->addFlash('error', 'Edite su perfil desde la administración');

            return $this->redirectToRoute('easyadmin', array('entity' => 'Usuario', 'action' => 'edit', 'id' => $this->getUser()->getId()));
        }

        $usuario = $this->getUser();

        $form = $this->createForm('AppBundle\Form\Type\UsuarioType', $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->preUpdateEntity($usuario);

            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            try {
                $em->flush();
                $this->addFlash('success', 'Se actualizó su perfil correctamente');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se pudo actualizar su perfil');
            }

            return $this->redirectToRoute('index');
        }

        return $this->render('usuario/perfil.html.twig', array(
            'usuario' => $usuario,
            'form' => $form->createView(),
        ));
    }

    /**
     * Metodo que genera la pagina de nuevo usuario y procesa los datos.
     *
     * @Route("/registro/", name="usuario_registro")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function registroAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $this->addFlash('error', 'Ya está registrado');

            return $this->redirectToRoute('index');
        }

        //Se crea la nueva entidad sobre la cual se guardaran los datos
        $usuario = new Usuario();

        // Se genera el form por medio de la evento UsuarioType que ya tiene todos los campos
        $form = $this->createForm('AppBundle\Form\Type\UsuarioType', $usuario, array(
            'accion' => 'registro',
            'validation_groups' => array('Default', 'Registro'),
        ));

        // Cuando se hace el post se invoca el metodo handleRequest que procesa la informacion del request
        $form->handleRequest($request);

        // Si el form contiene informacion valida y sin ningun error de validacion se guardan los datos
        if ($form->isSubmitted() && $form->isValid()) {
            $this->prePersistEntity($usuario);

            $usuario->setEstado('Paz y Salvo');
            $usuario->setActivo(false);

            // Se obtiene el entity manager de doctrine para generar el guardado
            $em = $this->getDoctrine()->getManager();
            // Se genera el codigo SQL para poder guardar los datos en la BD
            $em->persist($usuario);

            // Se ejecuta el codigo SQL generado por Doctrine con la instruccion anterior
            try {
                $em->flush();
                // Se agrega un mensaje para que pueda ser leido por el motor de plantillas twig
                $this->addFlash('success', 'Se registró el usuario correctamente. Debe esperar su activación por parte del administrador.');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se pudo registrar el usuario');
            }

            // Por ultimo se redirecciona a la pagina de usuarios
            return $this->redirectToRoute('index');
        }

        // Muestra el form mediante la accion createView de la variable form
        return $this->render('usuario/registro.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Metodo que lista los objetos encontrados en el sitio web.
     *
     * @Security("has_role('ROLE_DOCENTE') or has_role('ROLE_FUNCIONARIO')")
     * @Route("/mis_solicitudes/", name="mis_solicitudes")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function misSolicitudesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $solicitudesSala = $em->getRepository('AppBundle:SolicitudSala')->findBy(array(
            'usuarioRealiza' => $this->getUser(),
        ));

        $solicitudesSoftware = $em->getRepository('AppBundle:SolicitudSoftware')->findBy(array(
            'usuarioRealiza' => $this->getUser(),
        ));

        return $this->render('mis_solicitudes.html.twig', array(
            'solicitudesSala' => $solicitudesSala,
            'solicitudesSoftware' => $solicitudesSoftware,
        ));
    }

    /**
     * Metodo que genera el form de login.
     *
     * @Route("/login/", name="usuario_login")
     */
    public function loginAction()
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('index');
        }

        // crear aqui el form de login
        $authUtils = $this->get('security.authentication_utils');

        return $this->render('usuario/login.html.twig', array(
            'last_username' => $authUtils->getLastUsername(),
            'error' => $authUtils->getLastAuthenticationError(),
        ));
    }

    /**
     * El "login check" lo hace Symfony automáticamente, por lo que
     * no hay que añadir ningún código en este método.
     *
     * @Route("/login_check", name="usuario_login_check")
     */
    public function loginCheckAction()
    {
    }

    /**
     * El logout lo hace Symfony automáticamente, por lo que
     * no hay que añadir ningún código en este método.
     *
     * @Route("/logout/", name="usuario_logout")
     */
    public function logoutAction()
    {
    }

    protected function createNewForm($entity, array $entityProperties)
    {
        $builder = parent::createNewForm($entity, $entityProperties); // TODO: Change the autogenerated stub

        $builder->add('passwordEnClaro', RepeatedType::class, array(
            'type' => PasswordType::class,
            'invalid_message' => 'Las dos contraseñas deben coincidir',
            'first_options' => array('label' => 'Contraseña'),
            'second_options' => array('label' => 'Confirmar Contraseña'),
            'required' => false,
        ));

        return $builder;
    }

    protected function createEditForm($entity, array $entityProperties)
    {
        $builder = parent::createEditForm($entity, $entityProperties); // TODO: Change the autogenerated stub

//  { label: 'Contraseña', attr: { placeholder: 'Ingrese una nueva contraseña para modificar la actual.' }, }, second_options: { label: 'Confirmar Contraseña' }, required: false } }

        $builder->add('passwordEnClaro', RepeatedType::class, array(
            'type' => PasswordType::class,
            'invalid_message' => 'Las dos contraseñas deben coincidir',
            'first_options' => array(
                'label' => 'Contraseña',
                'attr' => array(
                    'placeholder' => 'Ingrese una nueva contraseña para modificar la actual.'
                )
            ),
            'second_options' => array('label' => 'Confirmar Contraseña'),
            'required' => false,
        ));

        return $builder;
    }


}

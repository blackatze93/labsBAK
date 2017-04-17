<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class UsuarioController.
 */
class UsuarioController extends BaseAdminController
{
    protected function prePersistEntity($entity)
    {
        // Se obtiene el encoder, que es el metodo de encriptacion de la entidad usuario
        $encoder = $this->get('security.encoder_factory')->getEncoder($entity);
        // Se codifica el password mediante el encoder
        $passwordCodificado = $encoder->encodePassword($entity->getPasswordEnClaro(), null);
        // Se establece el password en la entidad mediante el medoto setPassword
        $entity->setPassword($passwordCodificado);
    }

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
     * @Route("/perfil", name="usuario_perfil")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function perfilAction(Request $request)
    {
        $usuario = $this->getUser();

        $formulario = $this->createForm('AppBundle\Form\Type\UsuarioType', $usuario);
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $this->preUpdateEntity($usuario);

            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            try {
                $em->flush();
                $this->addFlash('success', 'Se actualizó el perfil correctamente');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se pudo actualizar el perfil');
            }

            return $this->redirectToRoute('index');
        }

        return $this->render('usuario/perfil.html.twig', array(
            'usuario' => $usuario,
            'formulario' => $formulario->createView(),
        ));
    }

    /**
     * Metodo que genera el formulario de login.
     *
     * @Route("/login", name="usuario_login")
     */
    public function loginAction()
    {
        // crear aqui el formulario de login
        $authUtils = $this->get('security.authentication_utils');

        return $this->render('usuario/login.html.twig', array(
            'last_username' => $authUtils->getLastUsername(),
            'error' => $authUtils->getLastAuthenticationError(),
        ));
    }

    /**
     * Metodo que genera el modal login en el menu principal.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function modalLoginAction()
    {
        $authUtils = $this->get('security.authentication_utils');

        return $this->render('usuario/_modal_login.html.twig', array(
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
     * @Route("/logout", name="usuario_logout")
     */
    public function logoutAction()
    {
    }
}

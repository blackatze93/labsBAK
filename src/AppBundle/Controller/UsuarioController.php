<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/usuario")
 */
class UsuarioController extends Controller
{
    /**
     * @Route("/", name="usuario_index")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $usuarios = $em->getRepository("AppBundle:Usuario")->findAll();

        return $this->render('usuario/index.html.twig', array(
            'usuarios' => $usuarios
        ));
    }

    /**
     * @Route("/login", name="usuario_login")
     */
    public function loginAction() {
        // crear aqui el formulario de login
        $authUtils = $this->get('security.authentication_utils');

        return $this->render('usuario/login.html.twig', array(
            'last_username' => $authUtils->getLastUsername(),
            'error' => $authUtils->getLastAuthenticationError(),
        ));
    }

    /**
     * @Route("/login_check", name="usuario_login_check")
     */
    public function loginCheckAction() {
        // el "login check" lo hace Symfony automáticamente, por lo que
        // no hay que añadir ningún código en este método
    }

    /**
     * @Route("/logout", name="usuario_logout")
     */
    public function logoutAction() {
        // el logout lo hace Symfony automáticamente, por lo que
        // no hay que añadir ningún código en este método
    }

    public function modalLoginAction() {
        // el logout lo hace Symfony automáticamente, por lo que
        // no hay que añadir ningún código en este método
        // crear aqui el formulario de login
        $authUtils = $this->get('security.authentication_utils');

        return $this->render('usuario/_modal_login.html.twig', array(
            'last_username' => $authUtils->getLastUsername(),
            'error' => $authUtils->getLastAuthenticationError(),
        ));
    }

    /**
     * @Route("/registro", name="usuario_registro")
     */
    public function registroAction(Request $request) {
        $usuario = new Usuario();
        $formulario = $this->createForm('AppBundle\Form\UsuarioType', $usuario, array(
            'accion' => 'crear_usuario',
        ));

        $formulario->handleRequest($request);

        if ($formulario->isValid()) {
            $encoder = $this->get('security.encoder_factory')->getEncoder($usuario);
            $passwordCodificado = $encoder->encodePassword($usuario->getPassword(), null);
            $usuario->setPassword($passwordCodificado);

            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();

            $this->addFlash('success', 'Se ha registrado correctamente');

            return $this->redirectToRoute('index');
        }

        return $this->render('usuario/registro.html.twig', array(
            'formulario' => $formulario->createView()
        ));
    }

    /**
     * @Route("/perfil", name="usuario_perfil")
     */
    public function perfilAction(Request $request) {
        $usuario = $this->getUser();
        $formulario = $this->createForm('AppBundle\Form\UsuarioType', $usuario, array(
            'accion' => 'modificar_perfil',
        ));

        $formulario->handleRequest($request);

        if ($formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();

            $this->addFlash('success', 'Se actualizó el perfil correctamente');
        }

        return $this->render('usuario/perfil.html.twig', array(
            'usuario' => $usuario,
            'formulario' => $formulario->createView()
        ));
    }
}
<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class UsuarioController
 * @package AppBundle\Controller
 *
 * @Route("usuario")
 */
class UsuarioController extends Controller {
    /**
     * Metodo que lista los usuarios de la aplicacion
     *
     * @Route("/", name="usuario_index")
     * @Method("GET")
     */
    public function indexAction() {
        $datatable = $this->get('app.datatable.usuario');
        $datatable->buildDatatable();

        return $this->render('usuario/index.html.twig', array(
           'datatable' => $datatable,
        ));
    }

    /**
     * @Route("/results", name="usuario_results")
     */
    public function indexResultsAction() {
        $datatable = $this->get('app.datatable.usuario');
        $datatable->buildDatatable();

        $query = $this->get('sg_datatables.query')->getQueryFrom($datatable);

        return $query->getResponse();
    }

    /**
     * Metodo que genera la pagina de nuevo usuario y procesa los datos
     *
     * @Route("/new", name="usuario_new")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction(Request $request) {
        //Se crea la nueva entidad sobre la cual se guardaran los datos
        $usuario = new Usuario();

        // Se genera el formulario por medio de la clase UsuarioType que ya tiene todos los campos
        $formulario = $this->createForm('AppBundle\Form\UsuarioType', $usuario, array(
            'accion' => 'new_usuario',
            'validation_groups' => array('Default', 'new'),
        ));

        // Cuando se hace el post se invoca el metodo handleRequest que procesa la informacion del request
        $formulario->handleRequest($request);

        // Si el formulario contiene informacion valida y sin ningun error de validacion se guardan los datos
        if ($formulario->isSubmitted() && $formulario->isValid()) {
            // Se obtiene el encoder, que es el metodo de encriptacion de la entidad usuario
            $encoder = $this->get('security.encoder_factory')->getEncoder($usuario);
            // Se codifica el password mediante el encoder
            $passwordCodificado = $encoder->encodePassword($usuario->getPasswordEnClaro(), null);
            // Se establece el password en la entidad mediante el medoto setPassword
            $usuario->setPassword($passwordCodificado);

            // Se obtiene el entity manager de doctrine para generar el guardado
            $em = $this->getDoctrine()->getManager();
            // Se genera el codigo SQL para poder guardar los datos en la BD
            $em->persist($usuario);

            // Se ejecuta el codigo SQL generado por Doctrine con la instruccion anterior
            try {
                $em->flush();
                // Se agrega un mensaje para que pueda ser leido por el motor de plantillas twig
                $this->addFlash('success', 'Se agregó el usuario correctamente');
            } catch (\Exception $e) {
                $this->addFlash('danger', 'No se pudo agregar el usuario');
            }

            // Por ultimo se redirecciona a la pagina de usuarios
            return $this->redirectToRoute('usuario_index');
        }

        // Muestra el formulario mediante la accion createView de la variable formulario
        return $this->render('usuario/new.html.twig', array(
            'formulario' => $formulario->createView()
        ));
    }

    /**
     * Metodo que permite ver el perfil de un usuario
     *
     * @Route("/{id}", name="usuario_show", requirements={"id": "\d+"}, options={"expose"=true})
     * @Method("GET")
     *
     * @param Usuario $usuario
     * @return Response
     */
    public function showAction(Usuario $usuario) {
        $deleteForm = $this->createDeleteForm($usuario);

        return $this->render('usuario/show.html.twig', array(
            'usuario' => $usuario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Metodo que permite ver el perfil de un usuario y modificarlo
     *
     * @Route("/{id}/edit", name="usuario_edit", requirements={"id": "\d+"}, options={"expose"=true})
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param Usuario $usuario
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, Usuario $usuario) {
        $deleteForm = $this->createDeleteForm($usuario);
        $formulario = $this->createForm('AppBundle\Form\UsuarioType', $usuario);
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            if ($usuario->getPasswordEnClaro() !== null) {
                $encoder = $this->get('security.encoder_factory')->getEncoder($usuario);
                $passwordCodificado = $encoder->encodePassword($usuario->getPasswordEnClaro(), null);
                $usuario->setPassword($passwordCodificado);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);

            try {
                $em->flush();
                $this->addFlash('success', 'Se edito el usuario correctamente');
            } catch (\Exception $e) {
                $this->addFlash('danger', 'No se pudo editar el usuario');
            }

            return $this->redirectToRoute('usuario_index');
        }

        return $this->render('usuario/edit.html.twig', array(
            'usuario' => $usuario,
            'formulario' => $formulario->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Metodo para eliminar un usuario
     *
     * @Route("/{id}", name="usuario_delete", requirements={"id": "\d+"})
     * @Method("DELETE")
     *
     * @param Request $request
     * @param Usuario $usuario
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Usuario $usuario) {
        $deleteForm = $this->createDeleteForm($usuario);
        $deleteForm->handleRequest($request);

        if ($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($usuario);
                $em->flush();

                $this->addFlash('success', 'Se eliminó correctamente la entidad');
            } catch (\Exception $e) {
                $this->addFlash('danger', 'No se pudo eliminar la entidad');
            }
        }
        return $this->redirectToRoute('usuario_index');
    }

    /**
     * Creates a form to delete a usuario entity.
     *
     * @param Usuario $usuario The usuario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Usuario $usuario) {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usuario_delete', array('id' => $usuario->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * Metodo que permite ver el perfil de un usuario y modificarlo
     *
     * @Route("/perfil", name="usuario_perfil")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function perfilAction(Request $request) {
        $usuario = $this->getUser();

        $formulario = $this->createForm('AppBundle\Form\UsuarioType', $usuario);
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            if ($usuario->getPasswordEnClaro() !== null) {
                $encoder = $this->get('security.encoder_factory')->getEncoder($usuario);
                $passwordCodificado = $encoder->encodePassword($usuario->getPasswordEnClaro(), null);
                $usuario->setPassword($passwordCodificado);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            try {
                $em->flush();
                $this->addFlash('success', 'Se actualizó el perfil correctamente');
            } catch (\Exception $e) {
                $this->addFlash('danger', 'No se pudo actualizar el perfil');
            }

            return $this->redirectToRoute('index');
        }

        return $this->render('usuario/perfil.html.twig', array(
            'usuario' => $usuario,
            'formulario' => $formulario->createView()
        ));
    }

    /**
     * Metodo que genera el formulario de login
     *
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
     * Metodo que genera el modal login en el menu principal
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function modalLoginAction() {
        $authUtils = $this->get('security.authentication_utils');

        return $this->render('usuario/_modal_login.html.twig', array(
            'last_username' => $authUtils->getLastUsername(),
            'error' => $authUtils->getLastAuthenticationError(),
        ));
    }

    /**
     * El "login check" lo hace Symfony automáticamente, por lo que
     * no hay que añadir ningún código en este método
     *
     * @Route("/login_check", name="usuario_login_check")
     */
    public function loginCheckAction() {
    }

    /**
     * El logout lo hace Symfony automáticamente, por lo que
     * no hay que añadir ningún código en este método
     *
     * @Route("/logout", name="usuario_logout")
     */
    public function logoutAction() {
    }

    /**
     * Bulk delete action.
     *
     * @param Request $request
     *
     * @Route("/bulk/delete", name="usuario_bulk_delete")
     * @Method("POST")
     *
     * @return Response
     */
    public function bulkDeleteAction(Request $request)
    {
        $isAjax = $request->isXmlHttpRequest();

        if ($isAjax) {
            $choices = $request->request->get('data');
            $token = $request->request->get('token');

            if (!$this->isCsrfTokenValid('multiselect', $token)) {
                throw new AccessDeniedException('The CSRF token is invalid.');
            }

            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository('AppBundle:Usuario');

            foreach ($choices as $choice) {
                $entity = $repository->find($choice['value']);
                $em->remove($entity);
            }

            try {
                $em->flush();
                return new Response('Success', 200);
            } catch (\Exception $e) {
                return new Response('Bad Request', 400);
            }
        }
        return new Response('Bad Request', 400);
    }

    /**
     * Bulk delete action.
     *
     * @param Request $request
     *
     * @Route("/bulk/enable", name="usuario_bulk_enable")
     * @Method("POST")
     *
     * @return Response
     */
    public function bulkEnableAction(Request $request)
    {
        $isAjax = $request->isXmlHttpRequest();

        if ($isAjax) {
            $choices = $request->request->get('data');
            $token = $request->request->get('token');

            if (!$this->isCsrfTokenValid('multiselect', $token)) {
                throw new AccessDeniedException('The CSRF token is invalid.');
            }

            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository('AppBundle:Usuario');

            foreach ($choices as $choice) {
                $entity = $repository->find($choice['value']);
                $entity->setEstaActivo(true);
                $em->persist($entity);
            }

            try {
                $em->flush();
                return new Response('Success', 200);
            } catch (\Exception $e) {
                return new Response('Bad Request', 400);
            }
        }
        return new Response('Bad Request', 400);
    }

    /**
     * Bulk delete action.
     *
     * @param Request $request
     *
     * @Route("/bulk/disable", name="usuario_bulk_disable")
     * @Method("POST")
     *
     * @return Response
     */
    public function bulkDisableAction(Request $request)
    {
        $isAjax = $request->isXmlHttpRequest();

        if ($isAjax) {
            $choices = $request->request->get('data');
            $token = $request->request->get('token');

            if (!$this->isCsrfTokenValid('multiselect', $token)) {
                throw new AccessDeniedException('The CSRF token is invalid.');
            }

            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository('AppBundle:Usuario');

            foreach ($choices as $choice) {
                $entity = $repository->find($choice['value']);
                $entity->setEstaActivo(false);
                $em->persist($entity);
            }

            try {
                $em->flush();
                return new Response('Success', 200);
            } catch (\Exception $e) {
                return new Response('Bad Request', 400);
            }
        }
        return new Response('Bad Request', 400);
    }
}
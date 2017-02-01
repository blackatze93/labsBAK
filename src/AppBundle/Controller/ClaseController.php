<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Clase;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Clase controller.
 *
 * @Route("clase")
 */
class ClaseController extends Controller
{
    /**
     * Metodo que lista los clases de la aplicacion.
     *
     * @Route("/", name="clase_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $datatable = $this->get('app.datatable.clase');
        $datatable->buildDatatable();

        return $this->render('clase/index.html.twig', array(
            'datatable' => $datatable,
        ));
    }

    /**
     * @Route("/results", name="clase_results")
     */
    public function indexResultsAction()
    {
        $datatable = $this->get('app.datatable.clase');
        $datatable->buildDatatable();

        $query = $this->get('sg_datatables.query')->getQueryFrom($datatable);

        return $query->getResponse();
    }

    /**
     * Creates a new clase entity.
     *
     * @Route("/new", name="clase_new")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $formulario = $this->createForm('AppBundle\Form\Type\ClaseType', null, array(
            'accion' => 'new_clase',
            'validation_groups' => array('Default', 'new'),
        ));
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $semanas = $formulario->getData()->getSemanas();

            for ($i = 0; $i < $semanas; $i++) {
                $clase = new Clase();
                $fechaAux = clone $formulario->getData()->getFecha();

                $clase->setLugar($formulario->getData()->getLugar());
                $clase->setFecha($fechaAux->modify('+'.$i.' week'));
                $clase->setHoraInicio($formulario->getData()->getHoraInicio());
                $clase->setHoraFin($formulario->getData()->getHoraFin());
                $clase->setEstado($formulario->getData()->getEstado());
                $clase->setMateria($formulario->getData()->getMateria());
                $clase->setGrupo($formulario->getData()->getGrupo());
                $clase->setObservaciones($formulario->getData()->getObservaciones());

                $em->persist($clase);
            }

            try {
                $em->flush();
                $em->clear();
                $this->addFlash('success', 'Se agregó la clase correctamente');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se pudo agregar la clase');
            }

            return $this->redirectToRoute('clase_index');
        }

        return $this->render('clase/new.html.twig', array(
            'formulario' => $formulario->createView(),
        ));
    }

    /**
     * Finds and displays a clase entity.
     *
     * @Route("/{id}", name="clase_show", requirements={"id": "\d+"}, options={"expose"=true})
     * @Method("GET")
     *
     * @param Clase $clase
     *
     * @return Response
     */
    public function showAction(Clase $clase)
    {
        $deleteForm = $this->createDeleteForm($clase);

        return $this->render('clase/show.html.twig', array(
            'clase' => $clase,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing clase entity.
     *
     * @Route("/{id}/edit", name="clase_edit", requirements={"id": "\d+"}, options={"expose"=true})
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param Clase   $clase
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, Clase $clase)
    {
        $deleteForm = $this->createDeleteForm($clase);
        $formulario = $this->createForm('AppBundle\Form\Type\ClaseType', $clase);
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($clase);

            try {
                $em->flush();
                $this->addFlash('success', 'Se edito la clase correctamente');

                return $this->redirectToRoute('clase_index');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se pudo editar la clase');

                return $this->redirectToRoute('clase_edit', array(
                    'id' => $request->get('id'),
                ));
            }
        }

        return $this->render('clase/edit.html.twig', array(
            'clase' => $clase,
            'formulario' => $formulario->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a clase entity.
     *
     * @Route("/{id}", name="clase_delete", requirements={"id": "\d+"})
     * @Method("DELETE")
     *
     * @param Request $request
     * @param Clase   $clase
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Clase $clase)
    {
        $formulario = $this->createDeleteForm($clase);
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($clase);
                $em->flush();

                $this->addFlash('success', 'Se eliminó correctamente la entidad');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se pudo eliminar la entidad');
            }
        }

        return $this->redirectToRoute('clase_index');
    }

    /**
     * Creates a form to delete a clase entity.
     *
     * @param Clase $clase The clase entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Clase $clase)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('clase_delete', array('id' => $clase->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Bulk delete action.
     *
     * @param Request $request
     *
     * @Route("/bulk/delete", name="clase_bulk_delete")
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
            $repository = $em->getRepository('AppBundle:Clase');

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
     * Bulk activate action.
     *
     * @param Request $request
     *
     * @Route("/bulk/activate", name="clase_bulk_activate")
     * @Method("POST")
     *
     * @return Response
     */
    public function bulkActivateAction(Request $request)
    {
        $isAjax = $request->isXmlHttpRequest();

        if ($isAjax) {
            $choices = $request->request->get('data');
            $token = $request->request->get('token');

            if (!$this->isCsrfTokenValid('multiselect', $token)) {
                throw new AccessDeniedException('The CSRF token is invalid.');
            }

            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository('AppBundle:Clase');

            foreach ($choices as $choice) {
                $entity = $repository->find($choice['value']);
                $entity->setEstado('Activa');
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
     * Bulk cancel action.
     *
     * @param Request $request
     *
     * @Route("/bulk/cancel", name="clase_bulk_cancel")
     * @Method("POST")
     *
     * @return Response
     */
    public function bulkCancelAction(Request $request)
    {
        $isAjax = $request->isXmlHttpRequest();

        if ($isAjax) {
            $choices = $request->request->get('data');
            $token = $request->request->get('token');

            if (!$this->isCsrfTokenValid('multiselect', $token)) {
                throw new AccessDeniedException('The CSRF token is invalid.');
            }

            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository('AppBundle:Clase');

            foreach ($choices as $choice) {
                $entity = $repository->find($choice['value']);
                $entity->setEstado('Cancelada');
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

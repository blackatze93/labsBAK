<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Estudiante;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Estudiante controller.
 *
 * @Route("estudiante")
 */
class EstudianteController extends Controller
{
    /**
     * Metodo que lista los estudiantees de la aplicacion.
     *
     * @Route("/", name="estudiante_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $datatable = $this->get('app.datatable.estudiante');
        $datatable->buildDatatable();

        return $this->render('estudiante/index.html.twig', array(
            'datatable' => $datatable,
        ));
    }

    /**
     * @Route("/results", name="estudiante_results")
     */
    public function indexResultsAction()
    {
        $datatable = $this->get('app.datatable.estudiante');
        $datatable->buildDatatable();

        $query = $this->get('sg_datatables.query')->getQueryFrom($datatable);

        return $query->getResponse();
    }

    /**
     * Creates a new estudiante entity.
     *
     * @Route("/new", name="estudiante_new")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $estudiante = new Estudiante();
        $formulario = $this->createForm('AppBundle\Form\Type\EstudianteType', $estudiante, array(
            'accion' => 'new_estudiante',
        ));
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($estudiante);

            try {
                $em->flush();
                $this->addFlash('success', 'Se agregó el estudiante correctamente');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se pudo agregar el estudiante');
            }

            return $this->redirectToRoute('estudiante_index');
        }

        return $this->render('estudiante/new.html.twig', array(
            'formulario' => $formulario->createView(),
        ));
    }

    /**
     * Finds and displays a estudiante entity.
     *
     * @Route("/{id}", name="estudiante_show", requirements={"id": "\d+"}, options={"expose"=true})
     * @Method("GET")
     *
     * @param Estudiante $estudiante
     *
     * @return Response
     */
    public function showAction(Estudiante $estudiante)
    {
        $deleteForm = $this->createDeleteForm($estudiante);

        return $this->render('estudiante/show.html.twig', array(
            'estudiante' => $estudiante,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing estudiante entity.
     *
     * @Route("/{id}/edit", name="estudiante_edit", requirements={"id": "\d+"}, options={"expose"=true})
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param Estudiante   $estudiante
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, Estudiante $estudiante)
    {
        $deleteForm = $this->createDeleteForm($estudiante);
        $formulario = $this->createForm('AppBundle\Form\Type\EstudianteType', $estudiante);
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($estudiante);

            try {
                $em->flush();
                $this->addFlash('success', 'Se edito el estudiante correctamente');

                return $this->redirectToRoute('estudiante_index');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se pudo editar el estudiante');

                return $this->redirectToRoute('estudiante_edit', array(
                    'id' => $request->get('id'),
                ));
            }
        }

        return $this->render('estudiante/edit.html.twig', array(
            'estudiante' => $estudiante,
            'formulario' => $formulario->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a estudiante entity.
     *
     * @Route("/{id}", name="estudiante_delete", requirements={"id": "\d+"})
     * @Method("DELETE")
     *
     * @param Request $request
     * @param Estudiante   $estudiante
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Estudiante $estudiante)
    {
        $formulario = $this->createDeleteForm($estudiante);
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($estudiante);
                $em->flush();

                $this->addFlash('success', 'Se eliminó correctamente la entidad');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se pudo eliminar la entidad');
            }
        }

        return $this->redirectToRoute('estudiante_index');
    }

    /**
     * Creates a formulario to delete a estudiante entity.
     *
     * @param Estudiante $estudiante The estudiante entity
     *
     * @return \Symfony\Component\Form\Form The formulario
     */
    private function createDeleteForm(Estudiante $estudiante)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('estudiante_delete', array('id' => $estudiante->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * Bulk delete action.
     *
     * @param Request $request
     *
     * @Route("/bulk/delete", name="estudiante_bulk_delete")
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
            $repository = $em->getRepository('AppBundle:Estudiante');

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
     * Bulk show action.
     *
     * @param Request $request
     *
     * @Route("/bulk/show", name="estudiante_bulk_show")
     * @Method("POST")
     *
     * @return Response
     */
    public function bulkShowAction(Request $request)
    {
        $isAjax = $request->isXmlHttpRequest();

        if ($isAjax) {
            $choices = $request->request->get('data');
            $token = $request->request->get('token');

            if (!$this->isCsrfTokenValid('multiselect', $token)) {
                throw new AccessDeniedException('The CSRF token is invalid.');
            }

            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository('AppBundle:Estudiante');

            foreach ($choices as $choice) {
                $entity = $repository->find($choice['value']);
                $entity->setVisible(true);
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
     * Bulk hide action.
     *
     * @param Request $request
     *
     * @Route("/bulk/hide", name="estudiante_bulk_hide")
     * @Method("POST")
     *
     * @return Response
     */
    public function bulkHideAction(Request $request)
    {
        $isAjax = $request->isXmlHttpRequest();

        if ($isAjax) {
            $choices = $request->request->get('data');
            $token = $request->request->get('token');

            if (!$this->isCsrfTokenValid('multiselect', $token)) {
                throw new AccessDeniedException('The CSRF token is invalid.');
            }

            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository('AppBundle:Estudiante');

            foreach ($choices as $choice) {
                $entity = $repository->find($choice['value']);
                $entity->setVisible(false);
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
     * Return a Response with the resources of the calendar.
     *
     * @return Response
     *
     * @internal param Request $request
     *
     * @Route("/fc-load-estudiantees", name="fullcalendar_estudiantees", options={"expose"=true})
     * @Method("POST")
     */
    public function cargarEstudianteesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $estudiantees = $em->getRepository('AppBundle:Estudiante')->findAllVisibles();

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $return_estudiantees = array();

        foreach ($estudiantees as $estudiante) {
            $return_estudiantees[] = $estudiante->toArray();
        }

        $response->setContent(json_encode($return_estudiantees));

        return $response;
    }
}

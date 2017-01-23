<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Evento;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Evento controller.
 *
 * @Route("evento")
 */
class EventoController extends Controller
{
    /**
     * Metodo que lista los eventos de la aplicacion.
     *
     * @Route("/", name="evento_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $datatable = $this->get('app.datatable.evento');
        $datatable->buildDatatable();

        return $this->render('evento/index.html.twig', array(
            'datatable' => $datatable,
        ));
    }

    /**
     * @Route("/results", name="evento_results")
     */
    public function indexResultsAction()
    {
        $datatable = $this->get('app.datatable.evento');
        $datatable->buildDatatable();

        $query = $this->get('sg_datatables.query')->getQueryFrom($datatable);

        return $query->getResponse();
    }

    /**
     * Creates a new evento entity.
     *
     * @Route("/new", name="evento_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $evento = new Evento();
        $formulario = $this->createForm('AppBundle\Form\EventoType', $evento, array(
            'accion' => 'new_evento',
        ));
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($evento);

            try {
                $em->flush();
                $this->addFlash('success', 'Se agregó el evento correctamente');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se pudo agregar el evento');
            }

            return $this->redirectToRoute('evento_index');
        }

        return $this->render('evento/new.html.twig', array(
            'evento' => $evento,
            'formulario' => $formulario->createView(),
        ));
    }

    /**
     * Finds and displays a evento entity.
     *
     * @Route("/{id}", name="evento_show", options={"expose"=true})
     * @Method("GET")
     */
    public function showAction(Evento $evento)
    {
        $deleteForm = $this->createDeleteForm($evento);

        return $this->render('evento/show.html.twig', array(
            'evento' => $evento,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing evento entity.
     *
     * @Route("/{id}/edit", name="evento_edit", options={"expose"=true})
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Evento $evento)
    {
        $deleteForm = $this->createDeleteForm($evento);
        $formulario = $this->createForm('AppBundle\Form\EventoType', $evento);
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($evento);

            try {
                $em->flush();
                $this->addFlash('success', 'Se edito el evento correctamente');

                return $this->redirectToRoute('evento_index');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se pudo editar el evento');

                return $this->redirectToRoute('evento_edit', array(
                    'id' => $request->get('id'),
                ));
            }
        }

        return $this->render('evento/edit.html.twig', array(
            'evento' => $evento,
            'formulario' => $formulario->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a evento entity.
     *
     * @Route("/{id}", name="evento_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Evento $evento)
    {
        $formulario = $this->createDeleteForm($evento);
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($evento);
                $em->flush();

                $this->addFlash('success', 'Se eliminó correctamente la entidad');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se pudo eliminar la entidad');
            }
        }

        return $this->redirectToRoute('evento_index');
    }

    /**
     * Creates a form to delete a evento entity.
     *
     * @param Evento $evento The evento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Evento $evento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('evento_delete', array('id' => $evento->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Bulk delete action.
     *
     * @param Request $request
     *
     * @Route("/bulk/delete", name="evento_bulk_delete")
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
            $repository = $em->getRepository('AppBundle:Evento');

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
}

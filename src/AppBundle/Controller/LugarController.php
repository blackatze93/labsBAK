<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Lugar;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Lugar controller.
 *
 * @Route("lugar")
 */
class LugarController extends Controller
{
    /**
     * Metodo que lista las dependencias de la aplicacion.
     *
     * @Route("/", name="lugar_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $datatable = $this->get('app.datatable.lugar');
        $datatable->buildDatatable();

        return $this->render('lugar/index.html.twig', array(
            'datatable' => $datatable,
        ));
    }

    /**
     * @Route("/results", name="lugar_results")
     */
    public function indexResultsAction()
    {
        $datatable = $this->get('app.datatable.lugar');
        $datatable->buildDatatable();

        $query = $this->get('sg_datatables.query')->getQueryFrom($datatable);

        return $query->getResponse();
    }

    /**
     * Creates a new lugar entity.
     *
     * @Route("/new", name="lugar_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $lugar = new Lugar();
        $formulario = $this->createForm('AppBundle\Form\LugarType', $lugar, array(
            'accion' => 'new_lugar',
        ));
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lugar);

            try {
                $em->flush();
                $this->addFlash('success', 'Se agregó el lugar correctamente');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se pudo agregar el lugar');
            }

            return $this->redirectToRoute('lugar_index');
        }

        return $this->render('lugar/new.html.twig', array(
            'lugar' => $lugar,
            'formulario' => $formulario->createView(),
        ));
    }

    /**
     * Finds and displays a lugar entity.
     *
     * @Route("/{id}", name="lugar_show", options={"expose"=true})
     * @Method("GET")
     */
    public function showAction(Lugar $lugar)
    {
        $deleteForm = $this->createDeleteForm($lugar);

        return $this->render('lugar/show.html.twig', array(
            'lugar' => $lugar,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a formulario to edit an existing lugar entity.
     *
     * @Route("/{id}/edit", name="lugar_edit", options={"expose"=true})
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Lugar $lugar)
    {
        $deleteForm = $this->createDeleteForm($lugar);
        $formulario = $this->createForm('AppBundle\Form\LugarType', $lugar);
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lugar);

            try {
                $em->flush();
                $this->addFlash('success', 'Se edito el lugar correctamente');

                return $this->redirectToRoute('lugar_index');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se pudo editar el lugar');

                return $this->redirectToRoute('lugar_edit', array(
                    'id' => $request->get('id'),
                ));
            }
        }

        return $this->render('lugar/edit.html.twig', array(
            'lugar' => $lugar,
            'formulario' => $formulario->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a lugar entity.
     *
     * @Route("/{id}", name="lugar_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Lugar $lugar)
    {
        $formulario = $this->createDeleteForm($lugar);
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($lugar);
                $em->flush();

                $this->addFlash('success', 'Se eliminó correctamente la entidad');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se pudo eliminar la entidad');
            }
        }

        return $this->redirectToRoute('lugar_index');
    }

    /**
     * Creates a formulario to delete a lugar entity.
     *
     * @param Lugar $lugar The lugar entity
     *
     * @return \Symfony\Component\Form\Form The formulario
     */
    private function createDeleteForm(Lugar $lugar)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('lugar_delete', array('id' => $lugar->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * Bulk delete action.
     *
     * @param Request $request
     *
     * @Route("/bulk/delete", name="lugar_bulk_delete")
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
            $repository = $em->getRepository('AppBundle:Lugar');

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
     * @Route("/bulk/show", name="lugar_bulk_show")
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
            $repository = $em->getRepository('AppBundle:Lugar');

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
     * @Route("/bulk/hide", name="lugar_bulk_hide")
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
            $repository = $em->getRepository('AppBundle:Lugar');

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
}
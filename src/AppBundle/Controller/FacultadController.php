<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Facultad;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Facultad controller.
 *
 * @Route("facultad")
 */
class FacultadController extends Controller
{
    /**
     * Metodo que lista las facultades de la aplicacion.
     *
     * @Route("/", name="facultad_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $datatable = $this->get('app.datatable.facultad');
        $datatable->buildDatatable();

        return $this->render('facultad/index.html.twig', array(
            'datatable' => $datatable,
        ));
    }

    /**
     * @Route("/results", name="facultad_results")
     */
    public function indexResultsAction()
    {
        $datatable = $this->get('app.datatable.facultad');
        $datatable->buildDatatable();

        $query = $this->get('sg_datatables.query')->getQueryFrom($datatable);

        return $query->getResponse();
    }

    /**
     * Creates a new facultad entity.
     *
     * @Route("/new", name="facultad_new")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $facultad = new Facultad();
        $formulario = $this->createForm('AppBundle\Form\Type\FacultadType', $facultad, array(
            'accion' => 'new_facultad',
        ));
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($facultad);

            try {
                $em->flush();
                $this->addFlash('success', 'Se agregó la facultad correctamente');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se pudo agregar la facultad');
            }

            return $this->redirectToRoute('facultad_index');
        }

        return $this->render('facultad/new.html.twig', array(
            'formulario' => $formulario->createView(),
        ));
    }

    /**
     * Finds and displays a facultad entity.
     *
     * @Route("/{id}", name="facultad_show", requirements={"id": "\d+"}, options={"expose"=true})
     * @Method("GET")
     *
     * @param Facultad $facultad
     *
     * @return Response
     */
    public function showAction(Facultad $facultad)
    {
        $deleteForm = $this->createDeleteForm($facultad);

        return $this->render('facultad/show.html.twig', array(
            'facultad' => $facultad,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a formulario to edit an existing facultad entity.
     *
     * @Route("/{id}/edit", name="facultad_edit", requirements={"id": "\d+"}, options={"expose"=true})
     * @Method({"GET", "POST"})
     *
     * @param Request  $request
     * @param Facultad $facultad
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, Facultad $facultad)
    {
        $deleteForm = $this->createDeleteForm($facultad);
        $formulario = $this->createForm('AppBundle\Form\Type\FacultadType', $facultad);
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($facultad);

            try {
                $em->flush();
                $this->addFlash('success', 'Se edito la facultad correctamente');

                return $this->redirectToRoute('facultad_index');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se pudo editar la facultad');

                return $this->redirectToRoute('facultad_edit', array(
                    'id' => $request->get('id'),
                ));
            }
        }

        return $this->render('facultad/edit.html.twig', array(
            'facultad' => $facultad,
            'formulario' => $formulario->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a facultad entity.
     *
     * @Route("/{id}", name="facultad_delete", requirements={"id": "\d+"})
     * @Method("DELETE")
     *
     * @param Request  $request
     * @param Facultad $facultad
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Facultad $facultad)
    {
        $formulario = $this->createDeleteForm($facultad);
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($facultad);
                $em->flush();

                $this->addFlash('success', 'Se eliminó correctamente la entidad');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se pudo eliminar la entidad');
            }
        }

        return $this->redirectToRoute('facultad_index');
    }

    /**
     * Creates a formulario to delete a facultad entity.
     *
     * @param Facultad $facultad The facultad entity
     *
     * @return \Symfony\Component\Form\Form The formulario
     */
    private function createDeleteForm(Facultad $facultad)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('facultad_delete', array('id' => $facultad->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * Bulk delete action.
     *
     * @param Request $request
     *
     * @Route("/bulk/delete", name="facultad_bulk_delete")
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
            $repository = $em->getRepository('AppBundle:Facultad');

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

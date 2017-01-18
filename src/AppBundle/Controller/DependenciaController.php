<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Dependencia;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Dependencia controller.
 *
 * @Route("dependencia")
 */
class DependenciaController extends Controller
{
    /**
     * Metodo que lista las dependencias de la aplicacion.
     *
     * @Route("/", name="dependencia_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $datatable = $this->get('app.datatable.dependencia');
        $datatable->buildDatatable();

        return $this->render('dependencia/index.html.twig', array(
            'datatable' => $datatable,
        ));
    }

    /**
     * @Route("/results", name="dependencia_results")
     */
    public function indexResultsAction()
    {
        $datatable = $this->get('app.datatable.dependencia');
        $datatable->buildDatatable();

        $query = $this->get('sg_datatables.query')->getQueryFrom($datatable);

        return $query->getResponse();
    }

    /**
     * Creates a new dependencia entity.
     *
     * @Route("/new", name="dependencia_new")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $dependencia = new Dependencia();
        $formulario = $this->createForm('AppBundle\Form\DependenciaType', $dependencia, array(
            'accion' => 'new_dependencia',
        ));
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dependencia);

            try {
                $em->flush();
                $this->addFlash('success', 'Se agregó la dependencia correctamente');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se pudo agregar la dependencia');
            }

            return $this->redirectToRoute('dependencia_index');
        }

        return $this->render('dependencia/new.html.twig', array(
            'dependencia' => $dependencia,
            'formulario' => $formulario->createView(),
        ));
    }

    /**
     * Finds and displays a dependencia entity.
     *
     * @Route("/{id}", name="dependencia_show", options={"expose"=true})
     * @Method("GET")
     *
     * @param Dependencia $dependencia
     *
     * @return Response
     */
    public function showAction(Dependencia $dependencia)
    {
        $deleteForm = $this->createDeleteForm($dependencia);

        return $this->render('dependencia/show.html.twig', array(
            'dependencia' => $dependencia,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a formulario to edit an existing dependencia entity.
     *
     * @Route("/{id}/edit", name="dependencia_edit", options={"expose"=true})
     * @Method({"GET", "POST"})
     *
     * @param Request     $request
     * @param Dependencia $dependencia
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, Dependencia $dependencia)
    {
        $deleteForm = $this->createDeleteForm($dependencia);
        $formulario = $this->createForm('AppBundle\Form\DependenciaType', $dependencia);
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dependencia);

            try {
                $em->flush();
                $this->addFlash('success', 'Se edito la dependencia correctamente');

                return $this->redirectToRoute('dependencia_index');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se pudo editar la dependencia');

                return $this->redirectToRoute('dependencia_edit', array(
                    'id' => $request->get('id'),
                ));
            }
        }

        return $this->render('dependencia/edit.html.twig', array(
            'dependencia' => $dependencia,
            'formulario' => $formulario->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a dependencia entity.
     *
     * @Route("/{id}", name="dependencia_delete")
     * @Method("DELETE")
     *
     * @param Request     $request
     * @param Dependencia $dependencia
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Dependencia $dependencia)
    {
        $formulario = $this->createDeleteForm($dependencia);
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($dependencia);
                $em->flush();

                $this->addFlash('success', 'Se eliminó correctamente la entidad');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se pudo eliminar la entidad');
            }
        }

        return $this->redirectToRoute('dependencia_index');
    }

    /**
     * Creates a formulario to delete a dependencia entity.
     *
     * @param Dependencia $dependencia The dependencia entity
     *
     * @return \Symfony\Component\Form\Form The formulario
     */
    private function createDeleteForm(Dependencia $dependencia)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dependencia_delete', array('id' => $dependencia->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Bulk delete action.
     *
     * @param Request $request
     *
     * @Route("/bulk/delete", name="dependencia_bulk_delete")
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
            $repository = $em->getRepository('AppBundle:Dependencia');

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

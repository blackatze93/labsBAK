<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ProyectoCurricular;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * ProyectoCurricular controller.
 *
 * @Route("proyectocurricular")
 */
class ProyectoCurricularController extends Controller
{
    /**
     * Metodo que lista las proyectocurriculars de la aplicacion.
     *
     * @Route("/", name="proyectocurricular_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $datatable = $this->get('app.datatable.proyectocurricular');
        $datatable->buildDatatable();

        return $this->render('proyectocurricular/index.html.twig', array(
            'datatable' => $datatable,
        ));
    }

    /**
     * @Route("/results", name="proyectocurricular_results")
     */
    public function indexResultsAction()
    {
        $datatable = $this->get('app.datatable.proyectocurricular');
        $datatable->buildDatatable();

        $query = $this->get('sg_datatables.query')->getQueryFrom($datatable);

        return $query->getResponse();
    }

    /**
     * Creates a new proyectocurricular entity.
     *
     * @Route("/new", name="proyectocurricular_new")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $proyectocurricular = new ProyectoCurricular();
        $formulario = $this->createForm('AppBundle\Form\Type\ProyectoCurricularType', $proyectocurricular, array(
            'accion' => 'new_proyectocurricular',
        ));
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($proyectocurricular);

            try {
                $em->flush();
                $this->addFlash('success', 'Se agregó la proyectocurricular correctamente');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se pudo agregar la proyectocurricular');
            }

            return $this->redirectToRoute('proyectocurricular_index');
        }

        return $this->render('proyectocurricular/new.html.twig', array(
            'formulario' => $formulario->createView(),
        ));
    }

    /**
     * Finds and displays a proyectocurricular entity.
     *
     * @Route("/{id}", name="proyectocurricular_show", requirements={"id": "\d+"}, options={"expose"=true})
     * @Method("GET")
     *
     * @param ProyectoCurricular $proyectocurricular
     *
     * @return Response
     */
    public function showAction(ProyectoCurricular $proyectocurricular)
    {
        $deleteForm = $this->createDeleteForm($proyectocurricular);

        return $this->render('proyectocurricular/show.html.twig', array(
            'proyectocurricular' => $proyectocurricular,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a formulario to edit an existing proyectocurricular entity.
     *
     * @Route("/{id}/edit", name="proyectocurricular_edit", requirements={"id": "\d+"}, options={"expose"=true})
     * @Method({"GET", "POST"})
     *
     * @param Request     $request
     * @param ProyectoCurricular $proyectocurricular
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, ProyectoCurricular $proyectocurricular)
    {
        $deleteForm = $this->createDeleteForm($proyectocurricular);
        $formulario = $this->createForm('AppBundle\Form\Type\ProyectoCurricularType', $proyectocurricular);
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($proyectocurricular);

            try {
                $em->flush();
                $this->addFlash('success', 'Se edito la proyectocurricular correctamente');

                return $this->redirectToRoute('proyectocurricular_index');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se pudo editar la proyectocurricular');

                return $this->redirectToRoute('proyectocurricular_edit', array(
                    'id' => $request->get('id'),
                ));
            }
        }

        return $this->render('proyectocurricular/edit.html.twig', array(
            'proyectocurricular' => $proyectocurricular,
            'formulario' => $formulario->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a proyectocurricular entity.
     *
     * @Route("/{id}", name="proyectocurricular_delete", requirements={"id": "\d+"})
     * @Method("DELETE")
     *
     * @param Request     $request
     * @param ProyectoCurricular $proyectocurricular
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, ProyectoCurricular $proyectocurricular)
    {
        $formulario = $this->createDeleteForm($proyectocurricular);
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($proyectocurricular);
                $em->flush();

                $this->addFlash('success', 'Se eliminó correctamente la entidad');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se pudo eliminar la entidad');
            }
        }

        return $this->redirectToRoute('proyectocurricular_index');
    }

    /**
     * Creates a formulario to delete a proyectocurricular entity.
     *
     * @param ProyectoCurricular $proyectocurricular The proyectocurricular entity
     *
     * @return \Symfony\Component\Form\Form The formulario
     */
    private function createDeleteForm(ProyectoCurricular $proyectocurricular)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('proyectocurricular_delete', array('id' => $proyectocurricular->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * Bulk delete action.
     *
     * @param Request $request
     *
     * @Route("/bulk/delete", name="proyectocurricular_bulk_delete")
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
            $repository = $em->getRepository('AppBundle:ProyectoCurricular');

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

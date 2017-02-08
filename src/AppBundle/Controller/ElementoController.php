<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Elemento;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Elemento controller.
 *
 * @Route("elemento")
 */
class ElementoController extends Controller
{
    /**
     * Metodo que lista los elementoes de la aplicacion.
     *
     * @Route("/", name="elemento_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $datatable = $this->get('app.datatable.elemento');
        $datatable->buildDatatable();

        return $this->render('elemento/index.html.twig', array(
            'datatable' => $datatable,
        ));
    }

    /**
     * @Route("/results", name="elemento_results")
     */
    public function indexResultsAction()
    {
        $datatable = $this->get('app.datatable.elemento');
        $datatable->buildDatatable();

        $query = $this->get('sg_datatables.query')->getQueryFrom($datatable);

        return $query->getResponse();
    }

    /**
     * Creates a new elemento entity.
     *
     * @Route("/new", name="elemento_new")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $elemento = new Elemento();
        $formulario = $this->createForm('AppBundle\Form\Type\ElementoType', $elemento, array(
            'accion' => 'new_elemento',
        ));
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($elemento);

            try {
                $em->flush();
                $this->addFlash('success', 'Se agregó el elemento correctamente');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se pudo agregar el elemento');
            }

            return $this->redirectToRoute('elemento_index');
        }

        return $this->render('elemento/new.html.twig', array(
            'formulario' => $formulario->createView(),
        ));
    }

    /**
     * Finds and displays a elemento entity.
     *
     * @Route("/{id}", name="elemento_show", requirements={"id": "\d+"}, options={"expose"=true})
     * @Method("GET")
     *
     * @param Elemento $elemento
     *
     * @return Response
     */
    public function showAction(Elemento $elemento)
    {
        $deleteForm = $this->createDeleteForm($elemento);

        return $this->render('elemento/show.html.twig', array(
            'elemento' => $elemento,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing elemento entity.
     *
     * @Route("/{id}/edit", name="elemento_edit", requirements={"id": "\d+"}, options={"expose"=true})
     * @Method({"GET", "POST"})
     *
     * @param Request    $request
     * @param Elemento $elemento
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, Elemento $elemento)
    {
        $deleteForm = $this->createDeleteForm($elemento);
        $formulario = $this->createForm('AppBundle\Form\Type\ElementoType', $elemento);
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($elemento);

            try {
                $em->flush();
                $this->addFlash('success', 'Se edito el elemento correctamente');

                return $this->redirectToRoute('elemento_index');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se pudo editar el elemento');

                return $this->redirectToRoute('elemento_edit', array(
                    'id' => $request->get('id'),
                ));
            }
        }

        return $this->render('elemento/edit.html.twig', array(
            'elemento' => $elemento,
            'formulario' => $formulario->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a elemento entity.
     *
     * @Route("/{id}", name="elemento_delete", requirements={"id": "\d+"})
     * @Method("DELETE")
     *
     * @param Request    $request
     * @param Elemento $elemento
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Elemento $elemento)
    {
        $formulario = $this->createDeleteForm($elemento);
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($elemento);
                $em->flush();

                $this->addFlash('success', 'Se eliminó correctamente la entidad');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se pudo eliminar la entidad');
            }
        }

        return $this->redirectToRoute('elemento_index');
    }

    /**
     * Creates a formulario to delete a elemento entity.
     *
     * @param Elemento $elemento The elemento entity
     *
     * @return \Symfony\Component\Form\Form The formulario
     */
    private function createDeleteForm(Elemento $elemento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('elemento_delete', array('id' => $elemento->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * Bulk delete action.
     *
     * @param Request $request
     *
     * @Route("/bulk/delete", name="elemento_bulk_delete")
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
            $repository = $em->getRepository('AppBundle:Elemento');

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

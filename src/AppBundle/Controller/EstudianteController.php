<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Estudiante;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Estudiante controller.
 *
 * @Route("estudiante")
 */
class EstudianteController extends Controller
{
    /**
     * Lists all estudiante entities.
     *
     * @Route("/", name="estudiante_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $estudiantes = $em->getRepository('AppBundle:Estudiante')->findAll();

        return $this->render('estudiante/index.html.twig', array(
            'estudiantes' => $estudiantes,
        ));
    }

    /**
     * Creates a new estudiante entity.
     *
     * @Route("/new", name="estudiante_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $estudiante = new Estudiante();
        $form = $this->createForm('AppBundle\Form\EstudianteType', $estudiante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($estudiante);
            $em->flush($estudiante);

            return $this->redirectToRoute('estudiante_show', array('id' => $estudiante->getId()));
        }

        return $this->render('estudiante/new.html.twig', array(
            'estudiante' => $estudiante,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a estudiante entity.
     *
     * @Route("/{id}", name="estudiante_show")
     * @Method("GET")
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
     * @Route("/{id}/edit", name="estudiante_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Estudiante $estudiante)
    {
        $deleteForm = $this->createDeleteForm($estudiante);
        $editForm = $this->createForm('AppBundle\Form\EstudianteType', $estudiante);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('estudiante_edit', array('id' => $estudiante->getId()));
        }

        return $this->render('estudiante/edit.html.twig', array(
            'estudiante' => $estudiante,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a estudiante entity.
     *
     * @Route("/{id}", name="estudiante_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Estudiante $estudiante)
    {
        $form = $this->createDeleteForm($estudiante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($estudiante);
            $em->flush($estudiante);
        }

        return $this->redirectToRoute('estudiante_index');
    }

    /**
     * Creates a form to delete a estudiante entity.
     *
     * @param Estudiante $estudiante The estudiante entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Estudiante $estudiante)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('estudiante_delete', array('id' => $estudiante->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

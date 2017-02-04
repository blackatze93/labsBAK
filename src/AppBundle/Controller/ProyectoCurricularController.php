<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ProyectoCurricular;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Proyectocurricular controller.
 *
 * @Route("proyectocurricular")
 */
class ProyectoCurricularController extends Controller
{
    /**
     * Lists all proyectoCurricular entities.
     *
     * @Route("/", name="proyectocurricular_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $proyectoCurriculars = $em->getRepository('AppBundle:ProyectoCurricular')->findAll();

        return $this->render('proyectocurricular/index.html.twig', array(
            'proyectoCurriculars' => $proyectoCurriculars,
        ));
    }

    /**
     * Creates a new proyectoCurricular entity.
     *
     * @Route("/new", name="proyectocurricular_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $proyectoCurricular = new Proyectocurricular();
        $form = $this->createForm('AppBundle\Form\ProyectoCurricularType', $proyectoCurricular);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($proyectoCurricular);
            $em->flush($proyectoCurricular);

            return $this->redirectToRoute('proyectocurricular_show', array('id' => $proyectoCurricular->getId()));
        }

        return $this->render('proyectocurricular/new.html.twig', array(
            'proyectoCurricular' => $proyectoCurricular,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a proyectoCurricular entity.
     *
     * @Route("/{id}", name="proyectocurricular_show")
     * @Method("GET")
     */
    public function showAction(ProyectoCurricular $proyectoCurricular)
    {
        $deleteForm = $this->createDeleteForm($proyectoCurricular);

        return $this->render('proyectocurricular/show.html.twig', array(
            'proyectoCurricular' => $proyectoCurricular,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing proyectoCurricular entity.
     *
     * @Route("/{id}/edit", name="proyectocurricular_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ProyectoCurricular $proyectoCurricular)
    {
        $deleteForm = $this->createDeleteForm($proyectoCurricular);
        $editForm = $this->createForm('AppBundle\Form\ProyectoCurricularType', $proyectoCurricular);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('proyectocurricular_edit', array('id' => $proyectoCurricular->getId()));
        }

        return $this->render('proyectocurricular/edit.html.twig', array(
            'proyectoCurricular' => $proyectoCurricular,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a proyectoCurricular entity.
     *
     * @Route("/{id}", name="proyectocurricular_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ProyectoCurricular $proyectoCurricular)
    {
        $form = $this->createDeleteForm($proyectoCurricular);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($proyectoCurricular);
            $em->flush($proyectoCurricular);
        }

        return $this->redirectToRoute('proyectocurricular_index');
    }

    /**
     * Creates a form to delete a proyectoCurricular entity.
     *
     * @param ProyectoCurricular $proyectoCurricular The proyectoCurricular entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ProyectoCurricular $proyectoCurricular)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('proyectocurricular_delete', array('id' => $proyectoCurricular->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

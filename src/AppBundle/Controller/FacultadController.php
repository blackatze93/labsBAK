<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Facultad;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Facultad controller.
 *
 * @Route("facultad")
 */
class FacultadController extends Controller
{
    /**
     * Lists all facultad entities.
     *
     * @Route("/", name="facultad_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $facultads = $em->getRepository('AppBundle:Facultad')->findAll();

        return $this->render('facultad/index.html.twig', array(
            'facultads' => $facultads,
        ));
    }

    /**
     * Creates a new facultad entity.
     *
     * @Route("/new", name="facultad_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $facultad = new Facultad();
        $form = $this->createForm('AppBundle\Form\FacultadType', $facultad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($facultad);
            $em->flush($facultad);

            return $this->redirectToRoute('facultad_show', array('id' => $facultad->getId()));
        }

        return $this->render('facultad/new.html.twig', array(
            'facultad' => $facultad,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a facultad entity.
     *
     * @Route("/{id}", name="facultad_show")
     * @Method("GET")
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
     * Displays a form to edit an existing facultad entity.
     *
     * @Route("/{id}/edit", name="facultad_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Facultad $facultad)
    {
        $deleteForm = $this->createDeleteForm($facultad);
        $editForm = $this->createForm('AppBundle\Form\FacultadType', $facultad);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('facultad_edit', array('id' => $facultad->getId()));
        }

        return $this->render('facultad/edit.html.twig', array(
            'facultad' => $facultad,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a facultad entity.
     *
     * @Route("/{id}", name="facultad_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Facultad $facultad)
    {
        $form = $this->createDeleteForm($facultad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($facultad);
            $em->flush($facultad);
        }

        return $this->redirectToRoute('facultad_index');
    }

    /**
     * Creates a form to delete a facultad entity.
     *
     * @param Facultad $facultad The facultad entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Facultad $facultad)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('facultad_delete', array('id' => $facultad->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

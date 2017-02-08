<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Elemento;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Elemento controller.
 *
 * @Route("elemento")
 */
class ElementoController extends Controller
{
    /**
     * Lists all elemento entities.
     *
     * @Route("/", name="elemento_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $elementos = $em->getRepository('AppBundle:Elemento')->findAll();

        return $this->render('elemento/index.html.twig', array(
            'elementos' => $elementos,
        ));
    }

    /**
     * Creates a new elemento entity.
     *
     * @Route("/new", name="elemento_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $elemento = new Elemento();
        $form = $this->createForm('AppBundle\Form\ElementoType', $elemento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($elemento);
            $em->flush($elemento);

            return $this->redirectToRoute('elemento_show', array('id' => $elemento->getId()));
        }

        return $this->render('elemento/new.html.twig', array(
            'elemento' => $elemento,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a elemento entity.
     *
     * @Route("/{id}", name="elemento_show")
     * @Method("GET")
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
     * @Route("/{id}/edit", name="elemento_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Elemento $elemento)
    {
        $deleteForm = $this->createDeleteForm($elemento);
        $editForm = $this->createForm('AppBundle\Form\ElementoType', $elemento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('elemento_edit', array('id' => $elemento->getId()));
        }

        return $this->render('elemento/edit.html.twig', array(
            'elemento' => $elemento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a elemento entity.
     *
     * @Route("/{id}", name="elemento_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Elemento $elemento)
    {
        $form = $this->createDeleteForm($elemento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($elemento);
            $em->flush($elemento);
        }

        return $this->redirectToRoute('elemento_index');
    }

    /**
     * Creates a form to delete a elemento entity.
     *
     * @param Elemento $elemento The elemento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Elemento $elemento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('elemento_delete', array('id' => $elemento->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

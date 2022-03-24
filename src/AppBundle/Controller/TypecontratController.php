<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Typecontrat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Typecontrat controller.
 *
 */
class TypecontratController extends Controller
{
    /**
     * Lists all typecontrat entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $typecontrats = $em->getRepository('AppBundle:Typecontrat')->findAll();

        return $this->render('typecontrat/index.html.twig', array(
            'typecontrats' => $typecontrats,
        ));
    }

    /**
     * Creates a new typecontrat entity.
     *
     */
    public function newAction(Request $request)
    {
        $typecontrat = new Typecontrat();
        $form = $this->createForm('AppBundle\Form\TypecontratType', $typecontrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typecontrat);
            $em->flush();

            return $this->redirectToRoute('contra_show', array('id' => $typecontrat->getId()));
        }

        return $this->render('typecontrat/new.html.twig', array(
            'typecontrat' => $typecontrat,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a typecontrat entity.
     *
     */
    public function showAction(Typecontrat $typecontrat)
    {
        $deleteForm = $this->createDeleteForm($typecontrat);

        return $this->render('typecontrat/show.html.twig', array(
            'typecontrat' => $typecontrat,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing typecontrat entity.
     *
     */
    public function editAction(Request $request, Typecontrat $typecontrat)
    {
        $deleteForm = $this->createDeleteForm($typecontrat);
        $editForm = $this->createForm('AppBundle\Form\TypecontratType', $typecontrat);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('contra_edit', array('id' => $typecontrat->getId()));
        }

        return $this->render('typecontrat/edit.html.twig', array(
            'typecontrat' => $typecontrat,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a typecontrat entity.
     *
     */
    public function deleteAction(Request $request, Typecontrat $typecontrat)
    {
        $form = $this->createDeleteForm($typecontrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typecontrat);
            $em->flush();
        }

        return $this->redirectToRoute('contra_index');
    }

    /**
     * Creates a form to delete a typecontrat entity.
     *
     * @param Typecontrat $typecontrat The typecontrat entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Typecontrat $typecontrat)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('contra_delete', array('id' => $typecontrat->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

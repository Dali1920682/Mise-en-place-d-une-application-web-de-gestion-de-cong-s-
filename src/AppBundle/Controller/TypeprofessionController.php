<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Typeprofession;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Typeprofession controller.
 *
 */
class TypeprofessionController extends Controller
{
    /**
     * Lists all typeprofession entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $typeprofessions = $em->getRepository('AppBundle:Typeprofession')->findAll();

        return $this->render('typeprofession/index.html.twig', array(
            'typeprofessions' => $typeprofessions,
        ));
    }

    /**
     * Creates a new typeprofession entity.
     *
     */
    public function newAction(Request $request)
    {
        $typeprofession = new Typeprofession();
        $form = $this->createForm('AppBundle\Form\TypeprofessionType', $typeprofession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeprofession);
            $em->flush();

            return $this->redirectToRoute('profession_show', array('id' => $typeprofession->getId()));
        }

        return $this->render('typeprofession/new.html.twig', array(
            'typeprofession' => $typeprofession,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a typeprofession entity.
     *
     */
    public function showAction(Typeprofession $typeprofession)
    {
        $deleteForm = $this->createDeleteForm($typeprofession);

        return $this->render('typeprofession/show.html.twig', array(
            'typeprofession' => $typeprofession,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing typeprofession entity.
     *
     */
    public function editAction(Request $request, Typeprofession $typeprofession)
    {
        $deleteForm = $this->createDeleteForm($typeprofession);
        $editForm = $this->createForm('AppBundle\Form\TypeprofessionType', $typeprofession);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profession_edit', array('id' => $typeprofession->getId()));
        }

        return $this->render('typeprofession/edit.html.twig', array(
            'typeprofession' => $typeprofession,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a typeprofession entity.
     *
     */
    public function deleteAction(Request $request, Typeprofession $typeprofession)
    {
        $form = $this->createDeleteForm($typeprofession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typeprofession);
            $em->flush();
        }

        return $this->redirectToRoute('profession_index');
    }

    /**
     * Creates a form to delete a typeprofession entity.
     *
     * @param Typeprofession $typeprofession The typeprofession entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Typeprofession $typeprofession)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('profession_delete', array('id' => $typeprofession->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

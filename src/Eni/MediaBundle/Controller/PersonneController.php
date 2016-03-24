<?php

namespace Eni\MediaBundle\Controller;

use Eni\MediaBundle\Entity\Personne;
use Eni\MediaBundle\Form\PersonneType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Personne controller.
 *
 * @Route("/personne")
 */
class PersonneController extends AbstractController
{
    /**
     * Lists all Personne entities.
     *
     * @Route("/", name="personne_index")
     * @Template
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getEntityManager();

        $personnes = $em->getRepository('EniMediaBundle:Personne')->findAll();

        return [
            'personnes' => $personnes,
        ];
    }

    /**
     * Creates a new Personne entity.
     *
     * @Template
     * @Route("/new", name="personne_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $personne = new Personne();
        $form = $this->createForm(PersonneType::class, $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getEntityManager();
            $em->persist($personne);
            $em->flush();

            return $this->redirectToRoute('personne_show', array('id' => $personne->getId()));
        }

        return [
            'personne' => $personne,
            'form'     => $form->createView(),
        ];
    }

    /**
     * Finds and displays a Personne entity.
     *
     * @Template
     * @Route("/{id}", name="personne_show")
     * @Method("GET")
     */
    public function showAction(Personne $personne)
    {
        $deleteForm = $this->createDeleteForm($personne);

        return [
            'personne'    => $personne,
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Displays a form to edit an existing Personne entity.
     *
     * @Template
     * @Route("/{id}/edit", name="personne_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Personne $personne)
    {
        $deleteForm = $this->createDeleteForm($personne);
        $editForm = $this->createForm(PersonneType::class, $personne);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getEntityManager();
            $em->persist($personne);
            $em->flush();
            return $this->redirectToRoute('personne_show', array('id' => $personne->getId()));
        }

        return [
            'personne'    => $personne,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Deletes a Personne entity.
     *
     * @Route("/{id}", name="personne_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Personne $personne)
    {
        $form = $this->createDeleteForm($personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getEntityManager();
            $em->remove($personne);
            $em->flush();
        }

        return $this->redirectToRoute('personne_index');
    }

    /**
     * Creates a form to delete a Personne entity.
     *
     * @param Personne $personne The Personne entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Personne $personne)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('personne_delete', array('id' => $personne->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}

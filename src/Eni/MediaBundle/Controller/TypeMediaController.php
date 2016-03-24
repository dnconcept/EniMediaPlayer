<?php

namespace Eni\MediaBundle\Controller;

use Eni\MediaBundle\Entity\TypeMedia;
use Symfony\Component\HttpFoundation\Request;

/**
 * TypeMedia controller.
 *
 */
class TypeMediaController extends AbstractController
{
    /**
     * Lists all TypeMedia entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getEntityManager();

        $typeMedia = $em->getRepository('EniMediaBundle:TypeMedia')->findAll();

        return $this->render('EniMediaBundle:typemedia:index.html.twig', array(
            'typeMedia' => $typeMedia,
        ));
    }

    /**
     * Creates a new TypeMedia entity.
     *
     */
    public function newAction(Request $request)
    {
        $typeMedia = new TypeMedia();
        $form = $this->createForm('Eni\MediaBundle\Form\TypeMediaType', $typeMedia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getEntityManager();
            $em->persist($typeMedia);
            $em->flush();

            return $this->redirectToRoute('typemedia_show', array('id' => $typeMedia->getId()));
        }

        return $this->render('EniMediaBundle:typemedia:new.html.twig', array(
            'typeMedia' => $typeMedia,
            'form'      => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TypeMedia entity.
     *
     */
    public function showAction(TypeMedia $typeMedia)
    {
        $deleteForm = $this->createDeleteForm($typeMedia);

        return $this->render('EniMediaBundle:typemedia:show.html.twig', array(
            'typeMedia'   => $typeMedia,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TypeMedia entity.
     *
     */
    public function editAction(Request $request, TypeMedia $typeMedia)
    {
        $deleteForm = $this->createDeleteForm($typeMedia);
        $editForm = $this->createForm('Eni\MediaBundle\Form\TypeMediaType', $typeMedia);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getEntityManager();
            $em->persist($typeMedia);
            $em->flush();
            return $this->redirectToRoute('typemedia_show', array('id' => $typeMedia->getId()));
        }

        return $this->render('EniMediaBundle:typemedia:edit.html.twig', array(
            'typeMedia'   => $typeMedia,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TypeMedia entity.
     *
     */
    public function deleteAction(Request $request, TypeMedia $typeMedia)
    {
        $form = $this->createDeleteForm($typeMedia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getEntityManager();
            $em->remove($typeMedia);
            $em->flush();
        }

        return $this->redirectToRoute('typemedia_index');
    }

    /**
     * Creates a form to delete a TypeMedia entity.
     *
     * @param TypeMedia $typeMedia The TypeMedia entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TypeMedia $typeMedia)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('typemedia_delete', array('id' => $typeMedia->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}

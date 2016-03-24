<?php

namespace Eni\MediaBundle\Controller;

use Eni\MediaBundle\Entity\Genre;
use Eni\MediaBundle\Form\GenreType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Genre controller.
 *
 */
class GenreController extends AbstractController
{

    /**
     * Lists all Genre entities.
     * @Template
     */
    public function indexAction()
    {
        $em = $this->getEntityManager();
        $genres = $em->getRepository(Genre::class)->findAll();
        return array(
            'genres' => $genres,
        );
    }

    public function listAjaxAction($format)
    {
        $repository = $this->getEntityManager()->getRepository(Genre::class);
        $data = $repository->findAll();
        return $this->createResponseListFromFormat($data, $format);
    }

    /**
     * Creates a new Genre entity.
     *
     * @Template
     */
    public function newAction(Request $request)
    {
        $genre = new Genre();
        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getEntityManager();
            $em->persist($genre);
            $em->flush();

            return $this->redirectToRoute('genre_show', array('id' => $genre->getId()));
        }

        return array(
            'genre' => $genre,
            'form'  => $form->createView(),
        );
    }

    /**
     * Finds and displays a Genre entity.
     *
     * @Template
     */
    public function showAction(Genre $genre)
    {
        $deleteForm = $this->createDeleteForm($genre);

        return array(
            'genre'       => $genre,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Genre entity.
     *
     * @Template
     */
    public function editAction(Request $request, Genre $genre)
    {
        $deleteForm = $this->createDeleteForm($genre);
        $editForm = $this->createForm(GenreType::class, $genre);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getEntityManager();
            $em->persist($genre);
            $em->flush();
            return $this->redirectToRoute('genre_show', array('id' => $genre->getId()));
        }

        return array(
            'genre'       => $genre,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Genre entity.
     *
     */
    public function deleteAction(Request $request, Genre $genre)
    {
        $form = $this->createDeleteForm($genre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getEntityManager();
            $em->remove($genre);
            $em->flush();
        }

        return $this->redirectToRoute('genre_index');
    }

    /**
     * Creates a form to delete a Genre entity.
     *
     * @param Genre $genre The Genre entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Genre $genre)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('genre_delete', array('id' => $genre->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

}

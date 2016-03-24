<?php

namespace Eni\MediaBundle\Controller;

use Eni\MediaBundle\Entity\Media;
use Eni\MediaBundle\Entity\TypeMedia;
use Eni\MediaBundle\Form\MediaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class MediaController extends AbstractController
{

    /**
     * @Template
     */
    public function listAction(Request $request)
    {
        $mediaRepository = $this->getEntityManager()->getRepository(Media::class);
        $typeMediaRepository = $this->getEntityManager()->getRepository(TypeMedia::class);
        if ($request->isXmlHttpRequest()) {
            $data = [];
            foreach ($mediaRepository->findAll() as $m) {
                $data[] = $m->toArray();
            }
            return new Response(json_encode($data));
        }
        return [
            'media'      => $mediaRepository->findAllWithUser(),
            'type_media' => $typeMediaRepository->findAll(),
        ];
    }

    public function testHtmlAction()
    {
        return $this->renderHtml("test.html", [
            "name" => "Mon nom",
        ]);
    }

    public function listAjaxAction($format)
    {
        $repository = $this->getEntityManager()->getRepository(Media::class);
        $data = $repository->findAllWithUser();
        return $this->createResponseListFromFormat($data, $format);
    }

    /**
     * @Template
     */
    public function addAction(Request $request)
    {
        $form = $this->createMediaForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Media $media */
            $media = $form->getData();
            try {
                $media->uploadMedia();
                $media->uploadPochette();
                $em = $this->getEntityManager();
                $em->persist($media);
                $em->flush();
                $this->addFlash("info", "Le media a été ajouté avec succès !");
            } catch (\Exception $exc) {
                $this->addFlash("error", $exc->getMessage());
            }
            return $this->redirectToRoute("media_list");
        }
        return [
            'media_form' => $form->createView()
        ];
    }

    /**
     * @Template
     */
    public function editAction(Request $request, Media $media)
    {
        $form = $this->createMediaForm($media);
        $form->remove("filePochette")->remove("fileMedia");
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Media $media */
            $media = $form->getData();
            try {
                $em = $this->getEntityManager();
                $em->persist($media);
                $em->flush();
                $this->addFlash("info", "Le media a été mis à jour avec succès !");
            } catch (\Exception $exc) {
                $this->addFlash("error", $exc->getMessage());
            }
            return $this->redirectToRoute("media_list");
        }
        return [
            'media_form' => $form->createView()
        ];
    }

    /**
     * Deletes a Personne entity.
     */
    public function deleteAction(Request $request, Media $media)
    {
        $statusCode = 200;
        if ($request->isMethod("DELETE")) {
            $em = $this->getEntityManager();
            $em->remove($media);
            $em->flush();
            $message = "Message du serveur ! Le media a été supprimé avec succès !";
        } else {
            $statusCode = 400;
            $message = "Message du serveur ! Impossible de supprimer le media !";
        }
        if ($request->isXmlHttpRequest()) {
            return new Response($message, $statusCode);
        }
        return $this->redirectToRoute('media_list');
    }

    private function createMediaForm(Media $media = null)
    {
        if ($media == null) {
            $media = new Media();
        }
        $form = $this->createForm(MediaType::class, $media);
        return $form;
    }

    /**
     * Creates a form to delete a Media entity.
     *
     * @param Personne $media The Media entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Media $media)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('media_delete', array('id' => $media->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

}

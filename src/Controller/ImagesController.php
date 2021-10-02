<?php

namespace App\Controller;

use App\Entity\Images;
use App\Form\ImagesType;
use App\Repository\ImagesRepository;
use App\Repository\TableauxRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ImagesController extends AbstractController
{
    /**
     * @Route("/art-vignette", name="images_index", methods={"GET"})
     */
    public function index(ImagesRepository $imagesRepository): Response
    {
        return $this->render('images/view_images.html.twig', [
            'liste_images' => $imagesRepository->findAll(),
        ]);
    }

   
    

    /**
     * @Route("/art-vignette/{id}/edit", name="images_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Images $image): Response
    {
        $form = $this->createForm(ImagesType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('images_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('images/edit.html.twig', [
            'image' => $image,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/art-vignettes/delete/{id}", name="images_supprime", methods={"POST"})
     */
    public function delete(Request $request, Images $image): Response
    {
        if ($this->isCsrfTokenValid('delete'.$image->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($image);
            $entityManager->flush();
        }

        return $this->redirectToRoute('images_index', [], Response::HTTP_SEE_OTHER);
    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\Carousel;
use App\Form\CarouselType;
use App\Repository\CarouselRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/carousel")
 */
class CarouselController extends AbstractController
{
    /**
     * @Route("/", name="carousel_index", methods={"GET"})
     */
    public function index(CarouselRepository $carouselRepository): Response
    {
        return $this->render('carousel/index.html.twig', [
            'carousels' => $carouselRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="carousel_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $carousel = new Carousel();
        $form = $this->createForm(CarouselType::class, $carousel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $image=$form->get('image')->getData();
            $image_name=uniqid().'.'.$image->guessExtension();
            $image->move($this->getParameter('upload_dir'), $image_name);
            
            $carousel->setImage($image_name);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($carousel);
            $entityManager->flush();

            return $this->redirectToRoute('carousel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('carousel/new.html.twig', [
            'carousel' => $carousel,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="carousel_show", methods={"GET"})
     */
    public function show(Carousel $carousel): Response
    {
        return $this->render('carousel/show.html.twig', [
            'carousel' => $carousel,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="carousel_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Carousel $carousel): Response
    {
        $form = $this->createForm(CarouselType::class, $carousel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('carousel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('carousel/edit.html.twig', [
            'carousel' => $carousel,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="carousel_delete", methods={"POST"})
     */
    public function delete(Request $request, Carousel $carousel): Response
    {
        if ($this->isCsrfTokenValid('delete'.$carousel->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($carousel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('carousel_index', [], Response::HTTP_SEE_OTHER);
    }
}

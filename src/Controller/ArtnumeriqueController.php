<?php

namespace App\Controller;

use App\Entity\Artnumerique;
use App\Form\ArtnumeriqueType;
use App\Repository\ArtnumeriqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/artnumerique")
 */
class ArtnumeriqueController extends AbstractController
{
    /**
     * @Route("/numerique", name="artnumerique_index", methods={"GET"})
     */
    public function index(ArtnumeriqueRepository $artnumeriqueRepository): Response
    {
        return $this->render('artnumerique/index.html.twig', [
            'artnumeriques' => $artnumeriqueRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="artnumerique_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $artnumerique = new Artnumerique();
        $form = $this->createForm(ArtnumeriqueType::class, $artnumerique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($artnumerique);
            $entityManager->flush();

            return $this->redirectToRoute('artnumerique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('artnumerique/new.html.twig', [
            'artnumerique' => $artnumerique,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="artnumerique_show", methods={"GET"})
     */
    public function show(Artnumerique $artnumerique): Response
    {
        return $this->render('artnumerique/show.html.twig', [
            'artnumerique' => $artnumerique,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="artnumerique_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Artnumerique $artnumerique): Response
    {
        $form = $this->createForm(ArtnumeriqueType::class, $artnumerique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('artnumerique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('artnumerique/edit.html.twig', [
            'artnumerique' => $artnumerique,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="artnumerique_delete", methods={"POST"})
     */
    public function delete(Request $request, Artnumerique $artnumerique): Response
    {
        if ($this->isCsrfTokenValid('delete'.$artnumerique->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($artnumerique);
            $entityManager->flush();
        }

        return $this->redirectToRoute('artnumerique_index', [], Response::HTTP_SEE_OTHER);
    }
}

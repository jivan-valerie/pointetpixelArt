<?php

namespace App\Controller\Artist;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Entity\Artnumerique;
use App\Form\ArtnumeriqueType;
use App\Repository\ArtnumeriqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


    /**
    * @Route("artist/artnumerique")
    */
    class DesignerController extends AbstractController
    {
     /**
      * @Route("/", name="mes_videos")
      */
     public function mesInsertVideos(): Response
        {
            $user=$this->getUser();


        return $this->render('designer/mes_videos.html.twig', [
            'user' => $user,

       ]);
     }

    /**
     * @Route("/new", name="add_video", methods={"GET","POST"})
     */
    public function create(Request $request): Response
    {
        $artnumerique = new Artnumerique();
        $form = $this->createForm(ArtnumeriqueType ::class, $artnumerique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user=$this->getUser();
            $artnumerique->setUser($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($artnumerique);
            $entityManager->flush();

            return $this->redirectToRoute('mes_videos', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('designer/new.html.twig', [
            'artnumerique' => $artnumerique,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="artnumerique_edit", methods={"GET","POST"})
     * @Security("user.getId() == user.getId()")
     */

    public function upDate($id, Request $request, Artnumerique $artnumerique, ArtnumeriqueRepository $artnumeriqueRepository): Response
    {
        if (!is_null($id)) {
        $video=$artnumeriqueRepository->find($id);

        $user=$this->getUser();

        $proprietaire= $video->getUser();

        if ($user != $proprietaire) {
            return $this->redirectToRoute('home');           
        }

        }else {
            return $this->redirectToRoute('home');
        }
        
        
        $form = $this->createForm(ArtnumeriqueType::class, $artnumerique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mes_videos', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('designer/edit.html.twig', [
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

        return $this->redirectToRoute('mes_videos', [], Response::HTTP_SEE_OTHER);
    }
}

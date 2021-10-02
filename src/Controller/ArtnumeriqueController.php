<?php

namespace App\Controller;

use App\Entity\Artnumerique;
use App\Repository\ArtnumeriqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ArtnumeriqueController extends AbstractController
{
    /**
     * @Route("/art-numerique", name="video", methods={"GET"})
     */
    public function ViewArtNum(ArtnumeriqueRepository $artnumeriqueRepository): Response
    {
        return $this->render('art_numerique/video.html.twig', [
            'videos' => $artnumeriqueRepository->findAuteur(),
        ]);
    }

    /**
     * @Route("/art-numerique/{id}", name="artnumerique_show", methods={"GET"})
     */
    public function showVideo(Artnumerique $artnumerique): Response
    {
        return $this->render('artnumerique/show.html.twig', [
            'artnumerique' => $artnumerique,
        ]);
    }

}

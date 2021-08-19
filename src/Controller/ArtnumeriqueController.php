<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArtNumeriqueController extends AbstractController
{
    /**
     * @Route("/art-numerique", name="art_numerique")
     */
    public function index(): Response
    {
        return $this->render('art_numerique/index.html.twig', [
            'controller_name' => 'ArtNumeriqueController',
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchTableauxController extends AbstractController
{
    /**
     * @Route("/search/tableaux", name="search_tableaux")
     */
    public function index(): Response
    {
        return $this->render('search_tableaux/index.html.twig', [
            'controller_name' => 'SearchTableauxController',
        ]);
    }
}

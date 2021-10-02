<?php

namespace App\Controller;

use App\Form\SearchTableauType;
use App\Repository\TableauxRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchTableauxController extends AbstractController
{
    /**
     * @Route("/search/tableaux", name="search_tableaux")
     */
    public function searchTableaux(Request $request, TableauxRepository $tableauxRepository ): Response
    {
        $searchForm = $this->createForm(SearchTableauType::class);
        if ($searchForm->handleRequest($request)->isSubmitted() && $searchForm->isValid()) {
            $criteria= $searchForm->getData();
            dd($criteria);
            $tableaux = $tableauxRepository->searchTableaux($criteria);
        }
        return $this->render('search_tableaux/index.html.twig', [
            'search_form' => $searchForm->createView(),
        ]);
    }
}

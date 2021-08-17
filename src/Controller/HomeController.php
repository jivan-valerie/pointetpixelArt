<?php

namespace App\Controller;

use App\Repository\CarouselRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TableauxRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index( CategoryRepository $categoryRepository, CarouselRepository $carouselRepository): Response
    {
        $user=$this->getUser();
        if ($user && $user->getBanni() == true) {
            return $this->redirectToRoute('app_logout');
            
        }
        $liste_category=$categoryRepository->findAll();
        return $this->render('home/index.html.twig', [
            'liste_category'=>$liste_category,
            'carousel'=>$carouselRepository->findAll(),
        ]);
    }
}
// /**
//      * @Route("/art_graphique", name="vitrine")
//      */
//     public function view(TableauxRepository $tableauxRepository) : Response
//     {
//     $liste_tableaux=$tableauxRepository->findBy(['vendu'=>false]);
//     return $this->render('tableau_user/view_tableaux.html.twig', 
//     [
//     'liste_tableaux'=>$liste_tableaux,
//     ]);
//     }
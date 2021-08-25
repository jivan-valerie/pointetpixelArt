<?php

namespace App\Controller;

use App\Repository\CarouselRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Classes\Panier;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Panier $panier, CategoryRepository $categoryRepository, CarouselRepository $carouselRepository): Response
    {


        $user=$this->getUser();
        if ($user && $user->getBanni() == true) {
            return $this->redirectToRoute('app_logout');
            
        }
        // $panier = $this->session->get('panier',[]);
        $liste_category=$categoryRepository->findAll();
        return $this->render('home/index.html.twig', [
            'liste_category'=>$liste_category,
            'carousel'=>$carouselRepository->findAll(),
            // 'panier'=>$panier->CalculQuantiteTotal(),
             'panier'=>$panier->afficheDetailPanier(), 

        ]);
    }
}

// $user=$this->getUser();

        

        
//         return $this->render('profil/index.html.twig', [
//             'user' => $user,
//             'commande'=>$commande,
//         //    'panier' =>$panier,
//         ]);
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
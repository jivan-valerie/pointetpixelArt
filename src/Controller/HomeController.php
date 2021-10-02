<?php

namespace App\Controller;

use App\Repository\CarouselRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Classes\Panier;
use App\Entity\Tableaux;
use App\Repository\TableauxRepository;
use App\Repository\UserRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Panier $panier, CategoryRepository $categoryRepository, CarouselRepository $carouselRepository, UserRepository $userRepository): Response
    {

        // Je récupère l'user connecté
        $user=$this->getUser();
        // si user existe et si il est banni alors redirection sur page connexion
        if ($user && $user->getBanni() == true) {
            return $this->redirectToRoute('app_logout');
            
        }
//  sinon je récupère les catégories, les images carousel, les utilisateurs enregistrés et le panier (pour afficher quantité)
        return $this->render('home/index.html.twig', [
            'liste_category'=>$categoryRepository->findAll(),
            'carousel'=>$carouselRepository->findAll(),
            'panier'=>$panier->afficheDetailPanier(), 
            'user'=>$userRepository->findAll()
        ]);
    }
     /**
     * @Route("/pointpixel", name="qui_sommes_nous")
     */
    public function identite(): Response
    {
        return $this->render('home/qui_sommes_nous.html.twig');
    }


    /**
     * @Route("/guide", name="guide")
     */
    public function guide(): Response
    {
        return $this->render('home/guide.html.twig');
    }


}




        

        
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
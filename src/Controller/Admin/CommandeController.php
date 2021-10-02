<?php

namespace App\Controller\Admin;

use App\Repository\CommandeRepository;
use App\Repository\TableauxRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{


    /**
     * @Route("admin/commandes", name="liste_commandes")
     */
    public function ListAchats(CommandeRepository $commandes, TableauxRepository $tableauxRepository): Response
    {   
        
        return $this->render('user/commandes.html.twig', [
            'commandes'=>$commandes->findAll(),
            'tableaux'=>$tableauxRepository->findAll()
        ]);
    }
    // /**
    //  * @Route("/commande", name="commande")
    //  */
    // public function index(CarouselRepository $carouselRepository): Response
    // {
    //     return $this->render('commande/index.html.twig', [
    //         'carousel' => $carouselRepository->findAll(),
    //     ]);
    // }
    // /**
    //  * @Route("/profil-tableaux", name="mes_commandes")
    //  */
    // public function MesAchats(): Response
    // {
    //     $user=$this->getUser();
    //     return $this->render('commande/indextwo.html.twig', [
    //         'user' => $user,
    
    //     ]);

    
    // }
    
}

<?php

namespace App\Controller;

use App\Classes\Panier;
use App\Entity\Tableaux;
use App\Repository\CategoryRepository;
use App\Repository\TableauxRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArtgraphiqueController extends AbstractController
{
    
    /**
     * @Route("/art-graphique", name="vitrine")
     */
    public function view(Panier $panier, TableauxRepository $tableauxRepository, CategoryRepository $categoryRepository ) : Response
    {
        
    
                $user=$this->getUser();
                if ($user && $user->getBanni() == true) {
                    return $this->redirectToRoute('app_logout');}
            //  $liste_tableaux=$tableauxRepository->findBy(['vendu'=>false]);
                $liste_tableaux = $tableauxRepository->findAll();
                $liste_categorie = $categoryRepository->findAll();
        
        return $this->render('art_graphique/view_tableaux.html.twig', 
        [
        'liste_tableaux'=> $liste_tableaux,
        'liste_categorie' => $liste_categorie,
        'panier'=>$panier->CalculQuantiteTotal(),
    ]);
    }
    /**
     * @Route("/art-graphique/divers", name="divers_art")
     */
    public function viewdivers(TableauxRepository $tableauxRepository, CategoryRepository $liste_categorie ) : Response
    {
    
            $liste_tableaux=$tableauxRepository->findAll();
        
        return $this->render('art_graphique/view_divers.html.twig', 
        [
        'liste_tableaux'=>$liste_tableaux,
        'liste_categorie' => $liste_categorie->findAll()

        ]);
    }

    /**
     * @Route("/detail-tableau/{id}", name="detail_tableau", methods={"GET"},)
     */
    public function show(Tableaux $tableau): Response
    {
        return $this->render('art_graphique/detail_tableaux.html.twig', [
            'tableau' => $tableau,
        ]);
    }
    /**
     * @Route("/vos-artist", name="mes_artistes", methods={"GET"})
     */
    public function ViewArtNum(TableauxRepository $tableauxRepository): Response
    {
        return $this->render('art_graphique/fiche_artist.html.twig', [
            'artist' => $tableauxRepository->findArtist(),
            'tableaux'=>$tableauxRepository->findAll(),
        ]);
    }
}

<?php

namespace App\Controller;

use App\Classes\Panier;
use App\Entity\Tableaux;
use App\Repository\CategoryRepository;
use App\Repository\TableauxRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


   

class TableauUserController extends AbstractController
{
   
    // /**
    //  * @Route("/artgraphique", name="artgraphique")
    //  */
    // public function index(): Response
    // {
    //     return $this->render('artgraphique/index.html.twig', [
    //         'controller_name' => 'ArtgraphiqueController',
    //     ]);
    // }
//    /**
//      * @Route("/art-graphique", name="vitrine")
//      */
//     public function view(Panier $panier, TableauxRepository $tableauxRepository, CategoryRepository $categoryRepository ) : Response
//     {
        
    
//                 $user=$this->getUser();
//                 if ($user && $user->getBanni() == true) {
//                     return $this->redirectToRoute('app_logout');}
//             //  $liste_tableaux=$tableauxRepository->findBy(['vendu'=>false]);
//                 $liste_tableaux = $tableauxRepository->findAll();
//                 $liste_categorie = $categoryRepository->findAll();
        
//         return $this->render('art_graphique/view_tableaux.html.twig', 
//         [
//         'liste_tableaux'=> $liste_tableaux,
//         'liste_categorie' => $liste_categorie,
//         'panier'=>$panier->CalculQuantiteTotal(),
//     ]);
//     }

//     /**
//      * @Route("/art-graphique/divers", name="divers_art")
//      */
//     public function viewdivers(TableauxRepository $tableauxRepository) : Response
//     {
    
//             $liste_tableaux=$tableauxRepository->findAll();
        
//         return $this->render('art_graphique/view_divers.html.twig', 
//         [
//         'liste_tableaux'=>$liste_tableaux,

//         ]);
//     }

    // /**
    //  * @Route("/art_graphique", name="vitrine")
    //  */
    // public function view(Panier $panier, TableauxRepository $tableauxRepository, CategoryRepository $categoryRepository ) : Response
    // {
        
    
    //             $user=$this->getUser();
    //             if ($user && $user->getBanni() == true) {
    //                 return $this->redirectToRoute('app_logout');}
    //         //  $liste_tableaux=$tableauxRepository->findBy(['vendu'=>false]);
    //             $liste_tableaux = $tableauxRepository->findAll();
    //             $liste_categorie = $categoryRepository->findAll();
        
    //     return $this->render('tableau_user/view_tableaux.html.twig', 
    //     [
    //     'liste_tableaux'=> $liste_tableaux,
    //     'liste_categorie' => $liste_categorie,
    //     'panier'=>$panier->CalculQuantiteTotal(),
    // ]);
    // }
    // /**
    //  * @Route("/art_graphique/DiversArt", name="divers-art")
    //  */
    // public function viewdivers(TableauxRepository $tableauxRepository) : Response
    // {
        
    
    //         $liste_tableaux=$tableauxRepository->findAll();
        
        
        
        
    //     return $this->render('tableau_user/view_divers.html.twig', 
    //     [
    //     'liste_tableaux'=>$liste_tableaux,

    //     ]);
    // }

    /**
     * @Route("/detail-tableau/{id}", name="detail_tableau", methods={"GET"},)
     */
    // public function show(Tableaux $tableau): Response
    // {
        

    //     return $this->render('art_graphique/detail_tableaux.html.twig', [
    //         'tableau' => $tableau,
    //     ]);
    // }

    // /**
    //  * @Route("/ajouter-tableau", name="add_tableau")
    //  */
    // public function addTableau(Request $request, EntityManagerInterface $entityManager,
    // TvaRepository $tvaRepository): Response
    // {
    //     $tva = $tvaRepository->find(1);
    //     $tableau= new Tableaux();
    //     $form=$this->createForm(TableauType::class, $tableau);
    //     $form->handleRequest($request);
        
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $image=$form->get('image')->getData();
    //         $image_name=uniqid().'.'.$image->guessExtension();
    //         $image->move($this->getParameter('upload_dir'), $image_name);
    //         $tableau->setTva($tva->getTva());
    //         $prix = $tableau->CalculPrix($tableau->getLongueur(), $tableau->getLargeur(),$tva->getTva());
    //         $tableau->setPrix($prix);
    //         $tableau->setImage($image_name);
    //         $user=$this->getUser();
    //         $tableau->setUser($user);
    //         $entityManager->persist($tableau);
    //         $entityManager->flush();
    //         return $this->redirectToRoute('vitrine');
    //     }
        
        
    //     return $this->render('tableau_user/add_tableaux.html.twig', [
    //     'form'=>$form->createView()
        
    //     ]);
    // }
    // /**
    //  * @Route("modifier-tableau/{id}", name="edituser_tableau", defaults = {"id" :null })
    //  */
    // public function editTableaux($id, TableauxRepository $tableauxRepository, Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     // id n'est pas nul
    //     if(!is_null($id) ){
    //         // je r??cup??re le tableau selon son id
    //         $tableau=$tableauxRepository->find($id);
    //         // je r??cup??re l'user connect??
    //         $user=$this->getUser();
    //         // je recup??re le proprietaire du tableau
    //         $proprietaire= $tableau->getUser();
    //         // je v??rifie si le propri??taire est bien l'user connect?? sinon je le redirige vers homme
    //         if($user != $proprietaire || !isset($tableau)){
    //             return $this->redirectToRoute('home');
    //         }
    //     } else {
    //         $tableau= new Tableaux();
    //     }
    //     $form=$this->createForm(TableauType::class, $tableau);
    //     $form->handleRequest($request);
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $image=$form->get('image')->getData();
    //         $image_name=uniqid().'.'.$image->guessExtension();
    //         $image->move($this->getParameter('upload_dir'), $image_name);
    //         $tableau->setImage($image_name);
    //         $entityManager->persist($tableau);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('oeuvre');
    //     }
    //     return $this->render('oeuvre/edit_tableaux.html.twig',[ 
    //         'form'=>$form->createView()
    //     ]);
    // }
    
}


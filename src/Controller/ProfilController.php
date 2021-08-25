<?php

namespace App\Controller;

use App\Classes\Panier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\RegistrationFormType;
use App\Repository\CommandeRepository;
use App\Form\TableauType;
use App\Entity\DetailCommande;
use App\Entity\Tableaux;
use App\Repository\TableauxRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProfilController extends AbstractController
{


/**
     * @Route("/profil", name="profil")
     */
    public function index(CommandeRepository $commande, Panier $panier): Response
    {   
        $user=$this->getUser();

        

        
        return $this->render('profil/index.html.twig', [
            'user' => $user,
            'commande'=>$commande,
            'panier'=>$panier->afficheDetailPanier(), 
        ]);
    }


    /**
     * @Route("modifier-tableau/{id}", name="modifier_tableauxuser", defaults = {"id" :null })
     */
    public function editTableaux(Panier $panier, $id, TableauxRepository $tableauxRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        // id n'est pas nul
        if(!is_null($id)){
            // je récupère le tableau selon son id
            $tableau=$tableauxRepository->find($id);
            // je récupère l'user connecté
            $user=$this->getUser();
            // je recupère le proprietaire du tableau
            $proprietaire= $tableau->getUser();
            // je vérifie si le propriétaire est bien l'user connecté sinon je le redirige vers homme
            if($user != $proprietaire){
                return $this->redirectToRoute('home');
            }
        } else {
            $tableau= new Tableaux();
        }
        $form=$this->createForm(TableauType::class, $tableau);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $image=$form->get('image')->getData();
            $image_name=uniqid().'.'.$image->guessExtension();
            $image->move($this->getParameter('upload_dir'), $image_name);
            $tableau->setImage($image_name);
            $entityManager->persist($tableau);
            $entityManager->flush();

            return $this->redirectToRoute('profil');
        }
        return $this->render('profil/modifier_tableaux.html.twig',[ 
            'form'=>$form->createView(),
            'panier'=>$panier->afficheDetailPanier(), 

        ]);
    }
    

    

    /**
     * @Route("/tableau/{id}", name="modifier_tableser", methods={"GET","POST"})
     */

    //  l'entité Tableaux et non Tableauxrepository car seul les tableaux de l'user sont recquis avec ses propriétés et pour le formulaire.
    public function edit(Request $request, Tableaux $tableaux ): Response
    {
        // en vertu des table-relationnelle : l'user connecté contient toutes les informations. 
        $user=$this->getUser();

        // le formulaire de modification reprend les données 
        $form = $this->createForm(TableauType::class, $tableaux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profil', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profil/modifier_tableaux.html.twig', [
            'user' => $user,
            'tableaux' => $tableaux,
        ]);
    }


    /**
     * @Route("/profil-tableaux", name="profil_tableaux")
     */
    public function MesTableaux(): Response
    {
        $user=$this->getUser();
        return $this->render('profil/mes_tableaux.html.twig', [
            'user' => $user,
          
        ]);
    }
    
     /**
     * @Route("/modifier-profil", name="edit_register")
     */
    public function modifierRegister(UserRepository $userRepository, Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
       $user=$this->getUser();// $user = $userRepository->find($id);
       if (!$user) {
           return $this-> redirectToRoute('home');
       }
       
        
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
     /**
     * @Route("/supprimer-profil", name="delete_profil")
     */

     
    public function deleteProfil(EntityManagerInterface $manager): Response
    {
        $user=$this->getUser();
  
        $manager->remove($user);
        
        $manager->flush();

        return $this->redirectToRoute('logout');
    }
}

<?php

namespace App\Controller\Artist;

use App\Classes\Panier;
use App\Entity\Tableaux;
use App\Form\TableauType;
use App\Repository\TableauxRepository;
use App\Repository\TvaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/artist")
*/

class ArtistController extends AbstractController
{
    
    /**
     * @Route("/ajouter-tableau", name="add_tableau")
     */
    public function addTableau(Request $request, EntityManagerInterface $entityManager,
    TvaRepository $tvaRepository): Response
    {
        $tva = $tvaRepository->find(1);
        $tableau= new Tableaux();
        $form=$this->createForm(TableauType::class, $tableau);
        $form->handleRequest($request);
        


        if ($form->isSubmitted() && $form->isValid()) {
            $image=$form->get('image')->getData();
            $image_name=uniqid().'.'.$image->guessExtension();
            $image->move($this->getParameter('upload_dir'), $image_name);
            $tableau->setTva($tva->getTva());
            $prix = $tableau->CalculPrix($tableau->getLongueur(), $tableau->getLargeur(),$tva->getTva());
            $tableau->setPrix($prix);
            $tableau->setImage($image_name);
            $user=$this->getUser();
            $tableau->setUser($user);
            $entityManager->persist($tableau);
            $entityManager->flush();
            return $this->redirectToRoute('mes_tableaux');
        }
        
        
        return $this->render('artist/add_tableaux.html.twig', [
        'form'=>$form->createView()
        
        ]);



    }
    /**
     * @Route("/tableaux", name="mes_tableaux")
     */
    public function mesInsertTableaux(Panier $panier): Response
    {   
        $user=$this->getUser();
    
        return $this->render('artist/mes_tableaux.html.twig', [
            'user' => $user,
            'panier'=>$panier->afficheDetailPanier(),
        
        ]);
    }

    /**
     * @Route("/modifier-tableau/{id}", name="modifier_tableauxuser", defaults = {"id" :null })
     */
    public function ModifierTableaux(Panier $panier, $id, TableauxRepository $tableauxRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        
            // je r??cup??re le tableau selon son id
            $tableau=$tableauxRepository->find($id);
           //si le tableau existe cad si id correspond ?? tableau.
           // condition doit ??tre plac??e ici sinon bug au niveau du proprietaire qui ne se v??rifie pas 
           // si pas de tableau, pas de proprietaire 
            if (!is_null($tableau)) {
                
             // si tableau-id existe je r??cup??re l'user connect??
            $user=$this->getUser();
            // si tableau-id existe, je recup??re le proprietaire du tableau
            $proprietaire= $tableau->getUser();
            // je v??rifie si le propri??taire est bien l'user connect?? sinon je le redirige vers homme
            if($user != $proprietaire){
                return $this->redirectToRoute('home');
            }
            // sinon si id tableaux n'existe pas, je redirige, sans chercher de proprietaire du tableau
            }else {
                return $this->redirectToRoute('home');
            }
            // je creer la vue qui est formulaire pre-rempli gr??ce aux donn??es mapp??e par l'id dans GET
            $form=$this->createForm(TableauType::class, $tableau);
            // je r??cup??re les donn??es du formulaire 
            $form->handleRequest($request);
            $image = $form->get("image")->getData();

                if ($form->isSubmitted() && $form->isValid()) {
                    $image=$form->get('image')->getData();
                    $image_name=uniqid().'.'.$image->guessExtension();
                    $image->move($this->getParameter('upload_dir'), $image_name);
                    $tableau->setImage($image_name);
                    $entityManager->persist($tableau);
                    $entityManager->flush();

                    return $this->redirectToRoute('mes_tableaux');
                }else {
                    // aucune nouvelle image envoy??e
                    //on recup??re l'ancienne image
                    $tableau->setImage($image);
                }
            // si le proprietaire = user alors je cr??er un nouvel objet tableau
    
        
        // le formulaire selon le builder du tableautype
        
        return $this->render('artist/modifier_tableaux.html.twig',[ 
            'form'=>$form->createView(),
            'panier'=>$panier->afficheDetailPanier(), 
            
        ]);
    }
    /**
     * @Route("/supprime-tableau/{id}", name="supprime_tableau" )
     */
    public function deleteMesTableaux(Tableaux $tableau): Response
    {
            

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($tableau);
        $entityManager->flush();
 
        return $this->redirectToRoute('mes_tableaux');
    }
    


}

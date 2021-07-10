<?php

namespace App\Controller;

use App\Entity\Tableaux;
use App\Form\TableauType;
use App\Repository\TableauxRepository;
use App\Repository\TvaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OeuvreController extends AbstractController
{
    /**
     * @Route("/oeuvre", name="oeuvre")
     */
    public function index(TableauxRepository $tableauxRepository): Response
    {
        $liste_tableaux=$tableauxRepository->findAll();
        return $this->render('oeuvre/tableaux.html.twig', [
        'liste_tableaux'=>$liste_tableaux,
        ]);
    }

    /**
     * @Route("/art_graphique", name="vitrine")
     */
    public function view(TableauxRepository $tableauxRepository) : Response
    {
    $liste_tableaux=$tableauxRepository->findAll();
    return $this->render('oeuvre/view_tableaux.html.twig', 
    [
    'liste_tableaux'=>$liste_tableaux,
    ]);
    }


    /**
     * @Route("/modifier-tableau/{id}", name="edit_tableau")
     */
    public function editTableaux($id, TableauxRepository $tableauxRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $tableau=$tableauxRepository->find($id);
        $form=$this->createForm(TableauType::class, $tableau);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $image=$form->get('image')->getData();
            $image_name=uniqid().'.'.$image->guessExtension();
            $image->move($this->getParameter('upload_dir'), $image_name);
            
            $tableau->setImage($image_name);
            $entityManager->persist($tableau);
            $entityManager->flush();

            return $this->redirectToRoute('oeuvre');
        }
        return $this->render('oeuvre/edit_tableaux.html.twig',[ 
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("detail-tableau/{id}", name="detail_tableau", methods={"GET"})
     */
    public function show(Tableaux $tableau): Response
    {
        

        return $this->render('oeuvre/detail_tableaux.html.twig', [
            'tableau' => $tableau,
        ]);
    }

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
            $entityManager->persist($tableau);
            $entityManager->flush();
            return $this->redirectToRoute('oeuvre');
        }
        
        
        return $this->render('oeuvre/add_tableaux.html.twig', [
        'form'=>$form->createView()
        
        ]);
    }
    /**
     * @Route("/delete-tableau/{id}", name="delete_tableau")
     */
    public function delete($id, TableauxRepository $tableauxRepository, EntityManagerInterface $entityManager){

        $tableau=$tableauxRepository->find($id);
        $entityManager->remove($tableau);
        $entityManager->flush();

        return $this->redirectToRoute('oeuvre');

    }
}
    
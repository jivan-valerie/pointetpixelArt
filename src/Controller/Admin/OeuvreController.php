<?php

namespace App\Controller\Admin;

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
     * @Route("admin/oeuvre", name="oeuvre")
     */
    public function index(TableauxRepository $tableauxRepository): Response
    {
        $liste_tableaux=$tableauxRepository->findAll();
        return $this->render('oeuvre/tableaux.html.twig', [
        'liste_tableaux'=>$liste_tableaux,
        ]);
    }

    /**
     * @Route("admin/modifier-tableau/{id}", name="edit_tableau", defaults = {"id" :null })
     */
    public function editTableaux($id, TableauxRepository $tableauxRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        if(!is_null($id)){
            $tableau=$tableauxRepository->find($id);
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

            return $this->redirectToRoute('oeuvre');
        }
        return $this->render('oeuvre/edit_tableaux.html.twig',[ 
            'form'=>$form->createView()
        ]);
    }
    

    
    /**
     * @Route("/delete-tableau/{id}", name="delete_tableau")
     */
    public function delete(Request $request,  Tableaux $tableau){
        if ($this->isCsrfTokenValid('delete'.$tableau->getId(), $request->request->get('_token'))) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($tableau);
        $entityManager->flush();

        return $this->redirectToRoute('oeuvre');

    }
}
// public function delete(Request $request, Carousel $carousel): Response
// {
//     if ($this->isCsrfTokenValid('delete'.$carousel->getId(), $request->request->get('_token'))) {
//         $entityManager = $this->getDoctrine()->getManager();
//         $entityManager->remove($carousel);
//         $entityManager->flush();
//     }

//     return $this->redirectToRoute('carousel_index', [], Response::HTTP_SEE_OTHER);
 }
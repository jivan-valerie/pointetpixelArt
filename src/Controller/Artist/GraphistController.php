<?php

namespace App\Controller\Artist;

use App\Classes\Panier;
use App\Entity\Images;
use App\Form\ImagesType;
use App\Repository\ImagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


    /**
     * @Route("/artist/images")
     */
class GraphistController extends AbstractController
{
    /**
     * @Route("/new", name="images_new", methods={"GET","POST"})
     */
    public function addImage(Request $request, EntityManagerInterface $entityManager): Response
    {
        $image = new Images();
        $form = $this->createForm(ImagesType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $figure=$form->get('image')->getData();
            $figure_name=uniqid().'.'.$figure->guessExtension();
            $figure->move($this->getParameter('upload_dir'), $figure_name);
            $image->setImage($figure_name);
            $user=$this->getUser();
            $image->setUser($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($image);
            $entityManager->flush();

            return $this->redirectToRoute('mes_images', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('graphist/new.html.twig', [
            'image' => $image,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/images", name="mes_images")
     */
    public function mesInsertImages(Panier $panier): Response
    {   
        $user=$this->getUser();
    
        return $this->render('graphist/mes_images.html.twig', [
            'user' => $user,
        
        ]);


    }

    /**
     * @Route("/modifier/{id}", name="modifier_image", defaults = {"id" :null })
     */
    public function ModifierImages(Panier $panier, $id, ImagesRepository $imagesRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        
            // je récupère le tableau selon son id
            $image=$imagesRepository->find($id);
            // si id existe de l'image existe = si image existe
            if(!is_null($image)){
            // je récupère l'user connecté

            $user=$this->getUser();
            // je recupère le proprietaire du tableau
            $proprietaire= $image->getUser();
            // je vérifie si le propriétaire est bien l'user connecté sinon je le redirige vers homme
            if($user != $proprietaire){
                return $this->redirectToRoute('home');
            }
            // si le proprietaire = user alors je créer un nouvel objet tableau
        } else {
            return $this->redirectToRoute('home');
        }
        // le formulaire selon le builder de l'imagetype
        $form=$this->createForm(ImagesType::class, $image);
        // récupère et vérifie les champs du formulaire
        $form->handleRequest($request);
        //Si le formulaire est validé et est valide 
        if ($form->isSubmitted() && $form->isValid()) {
        // Dans $figure je stocke l'image + les données de l'image
            $figure=$form->get('image')->getData();
        // dans $figure_name, je stocke le nom unique que j'attribuerai au fichier en gardant l'extension
            $figure_name=uniqid().'.'.$figure->guessExtension();
        // Je déplace le contenu de $figure = image et attribue nom qui figure 2 parametre de move
            $figure->move($this->getParameter('upload_dir'), $figure_name);
        // je modifie l'image avec les données de figure name qui contient aussi celle de figure=image
            $image->setImage($figure_name);
            $entityManager->persist($image);
            $entityManager->flush();

            return $this->redirectToRoute('mes_images');
        }
        return $this->render('graphist/edit.html.twig',[ 
            'form'=>$form->createView(),
            
        ]);
    }

    /**
     * @Route("delete/{id}", name="images_delete", methods={"POST"})
     */
    public function delete(Request $request, Images $image): Response
    {
        if ($this->isCsrfTokenValid('delete'.$image->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($image);
            $entityManager->flush();
        }

        return $this->redirectToRoute('mes_images', [], Response::HTTP_SEE_OTHER);
    }


}



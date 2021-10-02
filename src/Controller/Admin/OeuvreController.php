<?php

namespace App\Controller\Admin;

use App\Classes\Panier;
use App\Entity\Artnumerique;
use App\Entity\Images;
use App\Entity\Tableaux;
use App\Repository\ArtnumeriqueRepository;
use App\Repository\ImagesRepository;
use App\Repository\TableauxRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin/oeuvre")
 */
class OeuvreController extends AbstractController
{
 
    // cette méthode récupère tous les tableaux dans le repository : tous les objets instanciés de la class (concrète) tableaux
    //pour les renvoyer à la vue
    /**
     * @Route("/tableaux", name="oeuvre")
     */
    public function ListTableaux(Panier $panier, TableauxRepository $tableauxRepository): Response
    {
        $liste_tableaux=$tableauxRepository->findAll();
        return $this->render('oeuvre/tableaux.html.twig', [
        'liste_tableaux'=>$liste_tableaux,
        'panier'=>$panier->afficheDetailPanier(), 

        ]);
    }


    /**
     * @Route("/images", name="dash_images", methods={"GET"})
     */
    public function ListImages(ImagesRepository $imagesRepository): Response
    {
        return $this->render('oeuvre/images.html.twig', [
            'images' => $imagesRepository->findAll(),
        ]);
    }
        //  idem pour videos

    /**
     * @Route("/videos", name="dash_video")
     */
    public function ListVideo(Panier $panier, ArtnumeriqueRepository $videos): Response
    {
        return $this->render('oeuvre/list_video.html.twig', [
        'liste_videos'=>$videos->findAll(),
        'panier'=>$panier->afficheDetailPanier(), 

        ]);
    }
// récupère les données d'un tableau par la méthode Get id , la route 

    /**
     * @Route("/tableau/{id}", name="oeuvre_show", methods={"GET"})
     */
    public function showTableau(Panier $panier, Tableaux $tableaux): Response
    { 
        return $this->render('oeuvre/show_tableau.html.twig', [
            'tableaux' => $tableaux,
            'panier'=>$panier->afficheDetailPanier(), 

        ]);
    }
        //idem 


    /**
     * @Route("/video/{id}", name="video_show", methods={"GET"})
    */
    public function showVideo(Panier $panier, Artnumerique $video): Response
    { 
        return $this->render('oeuvre/show_video.html.twig', [
            'artnumerique' => $video,
            'panier'=>$panier->afficheDetailPanier(), 

        ]);
    }

        /**
     * @Route("/images/{id}", name="images_show", methods={"GET"})
     */
    public function showImages(Images $image): Response
    {
        return $this->render('oeuvre/show.html.twig', [
            'image' => $image,
        ]);
    }

    
// Attention cette méthode supprime directement le tableau, l'étape de confirmation doit être créer dans le template !!
    
    /**
     * @Route("/delete-tableau/{id}", name="delete_tableau",methods={"GET"} )
     */
    public function deleteTableau(Tableaux $tableau): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($tableau);
        $entityManager->flush();

        return $this->redirectToRoute('oeuvre');

    }


    /**
     * @Route("admin/delete-video/{id}", name="supprimer_video",methods={"GET"} )
    */
    public function deleteVideo(Artnumerique $video): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($video);
        $entityManager->flush();

        return $this->redirectToRoute('dash_video');

    }
     /**
     * @Route("/delete-uneimage/{id}", name="supprimer_uneimage",methods={"GET"} )
    */
    public function deleteImage(Images $image): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($image);
        $entityManager->flush();

        return $this->redirectToRoute('images_index');

    }
}

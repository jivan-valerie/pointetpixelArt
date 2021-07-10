<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Classes\Panier;
class PanierController extends AbstractController
{
    private $panier;

    public function __construct(Panier $panier)
    {
        $this->panier = $panier;
    }

    /**
     * @Route("/panier", name="panier")
     */
    public function index(): Response
    {
        return $this->render('panier/index.html.twig', [
            'panier'=>$this->panier->getPanier()
        ]);
    }
    /**
     * @Route("/addpanier/{id}", name="add_panier")
     */
    public function addOeuvrePanier($id): Response
    {
        $this->panier->add_oeuvre_panier($id);
        
        return $this->redirectToRoute('panier');
        
    }

    /**
     * @Route("/delete-panier", name="delete_panier")
     */
    public function deleteToutPanier(): Response
    {
        $this->panier->deletePanier();
        return $this->redirectToRoute('panier');
    }
    /**
     * @Route("/supprime-oeuvre/{id}", name="delete_oeuvre_panier")
     */
    public function deleteOeuvrePanier($id): Response
    {
        $this->panier->SupprimerOeuvrePanier($id);
        
        return $this->redirectToRoute('panier');
        
    } 

    /**
     * @Route("/addcinqpanier", name="add_5_panier")
     */
    public function add5Panier(Panier $panier): Response
    {
        $panier->ajouter5();
        
        return $this->redirectToRoute('panier');
        
    }
    /**
     * @Route("/supprime-une_oeuvre/{id}", name="delete_uneoeuvre_panier")
     */
    public function deleteUneOeuvrePanier($id, Panier $panier): Response
    {
        $panier->deleteUneOeuvre($id);
        
        return $this->redirectToRoute('panier');
        
    } 
}
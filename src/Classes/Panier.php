<?php
    
namespace App\Classes;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Panier 
{
    private $session;

    public function __construct(SessionInterface $session)
    {
       $this->session = $session; 
    }
// fonction qui ajoute article au panier et un paramètre obligatoire
    public function add_oeuvre_panier($variable){
        $panier = $this->session->get('panier',[]);


        // je teste le panier pour voir si la $varible existe

        if(!empty($panier[$variable])){
            // si elle existe je rajoute a la quantité 1 
            $panier[$variable] = $panier[$variable] + 1 ;
        }else{
           // si non je crée la donnée avec une valeur de 1 
            $panier[$variable] = 1 ;
        }
        
        // je renvoi a l'objet session les nouvelle valeur du panier )
        $this->session->set('panier',$panier);

        //}

    }

// fonction qui retourne le panier
    public function getPanier(){
        
        return $this->session->get('panier',[]);
    }

    public function deletePanier(){
        $this->session->remove('panier');
    }

    public function SupprimerOeuvrePanier($id){
        // je vais get panier
        $panier=$this->getpanier();
        //je verifi si c'e produit
            if (!empty($panier[$id])) {
    // sinon je le delete
                unset($panier[$id]);
    }
    $this->session->set('panier',$panier);
    }

    // ajoute 5 articles de id =1 à 4;
    public function ajouter5(){
    $panier=$this->getPanier();
    
    for ($i=1; $i < 5; $i++) { 
        $panier[$i] =1;
    }
    $this->session->set('panier',$panier);
}

//  funcion qui retire un à la quantité d'une oeuvre
    public function deleteUneOeuvre($id){
        
        $panier =$this->getPanier();

        if($panier[$id] >1){
            
            $panier[$id] = $panier[$id]-1;
        }else{
            unset($panier[$id]);
        }
        $this->session->set('panier',$panier);
    }

}
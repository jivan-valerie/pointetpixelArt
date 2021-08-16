<?php
    
namespace App\Classes;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\TableauxRepository;

class Panier 
{
    private $session;
    private $tableaurepository;

    public function __construct(SessionInterface $session, TableauxRepository $tableauxrepository)
    {
    $this->session = $session;
    $this->tableaurepository = $tableauxrepository;

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
        //je verifie si c'e produit
            if (!empty($panier[$id])) {
    // sinon je le delete
                unset($panier[$id]);
    }
    $this->session->set('panier',$panier);
    }


    public function deleteUneOeuvre($id){
        
        $panier =$this->getPanier();

        if($panier[$id] >1){
            
            $panier[$id] = $panier[$id]-1;
        }else{
            unset($panier[$id]);
        }
        $this->session->set('panier',$panier);
    }
    public function afficheDetailPanier()
    {
        $panier = $this->getPanier();
        $detail_panier =[];

        foreach ($panier as $key => $quantity) {
            $tableaux=$this->tableaurepository->find($key);

            $detail_panier[] = [
                'tableau' => $tableaux,
                'quantity'=>$quantity
            ];
        }
        return $detail_panier;
    }

    public function CalculTotal(){
        $total= 0 ;
        $panier=$this->afficheDetailPanier();

        foreach ($panier as $row){
            $prix=$row['tableau']->getPrix();
            $total=$total+($row['quantity']*$prix);

        }
        return $total;
    }

    public function CalculQuantiteTotal(){
        $quantitytotal= 0 ;
        $panier=$this->afficheDetailPanier();

        foreach ($panier as $row){
            // $quantitytotal=$row['tableau']->getQuantity();
            $quantitytotal=$quantitytotal+($row['quantity']);

        }
        return $quantitytotal;
    }
}
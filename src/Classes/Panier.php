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
    public function add_oeuvre_panier($item){
        // je récupère le contenu du panier avec get('panier'), je le défini comme un tableau vide par défaut
        $panier = $this->session->get('panier',[]);


        // je teste le panier pour voir si le panier a du contenu au moment de l'ajout d'un article
        
        if(!empty($panier[$item])){
            // si oui je rajoute 1 a la quantité préexistante, saachant que pour tableau, le produit est unique 
            $panier[$item] = $panier[$item] + 1 ;
        }else{
           // si non je crée la donnée avec une valeur de 1 
            $panier[$item] = 1 ;
        }
        
        // je renvoie a l'objet session les nouvelles valeurs du panier )
        $this->session->set('panier',$panier);

        //}

    }

// fonction qui retourne le panier dans ma session
    public function getPanier(){
        
        return $this->session->get('panier',[]);
    }

    public function deletePanier(){
        $this->session->remove('panier');
    }

    public function SupprimerOeuvrePanier($id){
        // je vais getter le panier
        $panier=$this->getpanier();
        //je verifie si le produit en question existe
            if (!empty($panier[$id])) {
        //  je le delete
                unset($panier[$id]);
    }
    // je renvoie à la session mon ''panier''modifié avec set,
    $this->session->set('panier',$panier);
    }


    public function deleteUneOeuvre($id){
        // je récupère le panier de la session avec l'id de l'oeuvre à supprimer, méthode getpanier
        $panier =$this->getPanier();
        // si contenu est supérieure à un je retire 1
        if($panier[$id] >1){
            
            $panier[$id] = $panier[$id]-1;
        // si contenu = 1 équivaut à supprimer panier
        }else{
            unset($panier[$id]);
        }
        // on 'l'enregistre dans la session'
        $this->session->set('panier',$panier);
    }

    public function afficheDetailPanier()
    {
        // méthode get panier qui récupére contenu panier de la session
        $panier = $this->getPanier();
        $detail_panier =[];
        // pour chaque article panier identifié par sa key = id et quantié
        foreach ($panier as $key => $quantity) {
            //chaque tableau dans panier, on récupére sa cle =id
            $tableaux=$this->tableaurepository->find($key);
            //dans notre cas particulier la quantité est toujours un
            
            $quantity = 1;
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
            // la boucle parcourt le tableau panier ligne par ligne, et récupère le prix qui est propriété de la class objet instancié en ces objets tableaux précis du panier;
            // 
            $prix=$row['tableau']->getPrix();
            //idem pour la quantité; le total est l'addition de toutes les lignes (tableaux) qui multiplie chacun le prix par sa quantité (ici 1) row quantité = 1
            $total=$total+(1*$prix);

        }
        return $total;
    }

    public function CalculQuantiteTotal(){
        $quantitytotal= 0 ;
        $panier=$this->afficheDetailPanier();

        foreach ($panier as $row){
            $quantitytotal=$quantitytotal+1;

        }
        return $quantitytotal;
    }
}
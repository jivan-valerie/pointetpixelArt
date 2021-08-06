<?php

namespace App\Controller;
use App\Classes\Panier;
use App\Entity\Commande;
use App\Entity\DetailCommande;
use App\Repository\TableauxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;
class AchatController extends AbstractController
{
    /**
     * @Route("user/achat", name="achat")
     */
    public function index(EntityManagerInterface $manager, Panier $panier,
                            TableauxRepository $tableauxRepository): Response
    {

        $commande = new Commande();
        
        $user= $this->getUser();
        $datecommande= new DateTime("now",new \DateTimeZone('Europe/Paris')
    );
        
        $adresse = $user->getAdresse();
        // $nom = $user->getNom();
        $total = $panier->CalculTotal();
        
        $commande->setUser($user);
        $commande->setDateCommande($datecommande);
        // $commande->setNom($nom);
        $commande->setAdresse($adresse);
        $commande->setTotal($total);
        $manager->persist($commande);
        $detail_panier=$panier->afficheDetailPanier();
       
//  hydrate la BDD détail-commande recuperé dans panier article par article
    foreach($detail_panier as $row)
        {
    $detail_commande= new DetailCommande ();

    //tableau vendu true o false 
    $id_tableau=$row['tableau']->getId();
    $tableau=$tableauxRepository->find($id_tableau);
    $tableau->setVendu(true);
    $manager->persist($tableau);
    
    $detail_commande->setCommande($commande);
    $detail_commande->setTitre($row['tableau']->getTitre());
    $detail_commande->setAuteur($row['tableau']->getAuteur());
    $detail_commande->setPrix($row['tableau']->getPrix());
    $manager->persist($detail_commande);

}

$manager->flush();
        
        $detail_panier=$panier->deletePanier();
        return $this->redirectToRoute('panier');
    
    }


    /**
     * @Route("user/achat-unarticle/{id}", name="un_seul_achat")
     */
    public function Achat_tableau($id, EntityManagerInterface $manager, Panier $panier,
                            TableauxRepository $tableauxRepository): Response
    {

        $commande = new Commande();
        
        $user= $this->getUser();
        $datecommande= new DateTime("now",new \DateTimeZone('Europe/Paris')
    );
        
        $adresse = $user->getAdresse();
        // $nom = $user->getNom();
        $total = $panier->CalculTotal();
        
        $commande->setUser($user);
        $commande->setDateCommande($datecommande);
        // $commande->setNom($nom);
        $commande->setAdresse($adresse);
        $commande->setTotal($total);
        $manager->persist($commande);
        // $detail_panier=$panier->afficheDetailPanier();
       
//  hydrate la BDD détail-commande recuperé dans panier article par article
    $tableau=$tableauxRepository->find($id);
    $detail_commande= new DetailCommande ();

    // tableau vendu true o false 
    
    $tableau->setVendu(true);
    $manager->persist($tableau);
    
    $detail_commande->setCommande($commande);
    $detail_commande->setTitre($tableau->getTitre());
    $detail_commande->setAuteur($tableau->getAuteur());
    $detail_commande->setPrix($tableau->getPrix());
    $manager->persist($detail_commande);



    $manager->flush();
        
        $panier->SupprimerOeuvrePanier($id);
        return $this->redirectToRoute('panier');
    
    }

    
}

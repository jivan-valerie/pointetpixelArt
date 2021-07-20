<?php

namespace App\Controller;
use App\Classes\Panier;
use App\Entity\Commande;
use App\Entity\DetailCommande;
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
    public function index(EntityManagerInterface $manager, Panier $panier): Response
    {

        $commande = new Commande();
        
        $user= $this->getUser();
        $datecommande= new DateTime("now",new \DateTimeZone('Europe/Paris')
    );
        
        $adresse = $user->getAdresse();
        $total = $panier->CalculTotal();
        
        $commande->setUser($user);
        $commande->setDateCommande($datecommande);
        $commande->setAdresse($adresse);
        $commande->setTotal($total);

        $manager->persist($commande);
        $manager->flush();
        $detail_panier=$panier->afficheDetailPanier();
       
//  hydrate la BDD détail-commande
    foreach($detail_panier as $row)
        {
    $detail_commande= new DetailCommande ();

    $detail_commande->setCommande($commande);
    $detail_commande->setTitre($row['tableau']->getTitre());
    $detail_commande->setAuteur($row['tableau']->getAuteur());
    $detail_commande->setPrix($row['tableau']->getPrix());

    $manager->persist($detail_commande);

}

$manager->flush();

    
        return $this->redirectToRoute('panier');
    
    }
}

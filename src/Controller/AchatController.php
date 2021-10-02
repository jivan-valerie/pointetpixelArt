<?php

namespace App\Controller;
use App\Classes\Panier;
use App\Entity\Commande;
use App\Repository\TableauxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use DateTime;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class AchatController extends AbstractController
{
    /**
     * @Route("user/achat", name="achat")
     */
    public function Achats(EntityManagerInterface $manager, Panier $panier,
                            TableauxRepository $tableauxRepository,MailerInterface $mailer ): Response
    {
        $detail_panier=$panier->afficheDetailPanier();

        foreach($detail_panier as $row){

    // on instancie un objet à partir de la classe Commande, lié à la table user
        $commande = new Commande();
    // on récupère l'utilisateur connecté, objet classe user et la date par Date Time    
        $user= $this->getUser();
        $datecommande= new DateTime("now",new \DateTimeZone('Europe/Paris')
    );
        // Attribution valeurs : Les propriétés de l'Entité Commande instanciée en cette commande de cet utilisateur connecté
        // On récupère l'adresse utilisateur
        //  $adresse = $user->getAdresse();
        // $email = $user->getEmail();

        // le total du panier par la fonction calcultotal de la classe panier
    
        $id_tableau=$row['tableau']->getId();
        $tableau=$tableauxRepository->find($id_tableau);

        $tableau->setVendu(true);
        $manager->persist($tableau);
        $total = $panier->CalculTotal();
        // on attribue les valeurs aux propriètes commande : la propriétés users paar les les données utilisateurs stockées dans $user
        $commande->setUser($user);
        // la propriété datecommande par les valeur stockée dans datecommande de new commande
        $commande->setDateCommande($datecommande);
        $commande->setTableaux($tableau);

        $commande->setTotal($total);
        $manager->persist($commande);
        // $detail_panier=$panier->afficheDetailPanier();
        
        
        
       
//  hydrate la BDD détail-commande recuperé dans panier article par article
    // foreach($detail_panier as $row)
    //     {
    // $commande= new Commande ();

    
    
    // $detail_commande->setCommande($commande);
   
    // $commande->setTitre($row);
    // $detail_commande->setTitre($row['tableau']->getTitre());
    // $detail_commande->setAuteur($row['tableau']->getAuteur());
    // $detail_commande->setImage($row['tableau']->getAuteur());
    // $detail_commande->setPrix($row['tableau']->getPrix());
    $email_proprietaire =$row['tableau']->getUser();
    $manager->persist($commande);
    $sendemail = (new  TemplatedEmail())
        ->from($user->getEmail())
        ->to($email_proprietaire->getEmail())
        ->subject('Verification disponibilité tableau')
        ->htmlTemplate('emails/email_verification.html.twig');
        // ->text('Votre tableau a été selectioné pour un éventuel achat. Veuillez confirmer sa disponibilité.
        //  Si, à breve, aucune réponse, nous est donée nous annulerons la commande. Point et Pixel. Veuillez nous contactez au ');
    //     ->html('<p>See Twig integration for better HTML integration!</p>');
    $mailer->send($sendemail);}
    $this->addFlash('success', 'Votre message a été envoyé');
// }

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
        $datecommande= new DateTime("now",new \DateTimeZone('Europe/Paris'));
        
        // $adresse = $user->getAdresse();
        // $nom = $user->getNom();
        
        
        $total = $panier->CalculTotal();
        
        $commande->setUser($user);
        $commande->setDateCommande($datecommande);


        // $commande->setAdresse($adresse);


        $commande->setTotal($total);
        $manager->persist($commande);
        // $detail_panier=$panier->afficheDetailPanier();

//  hydrate la BDD détail-commande recuperé dans panier article par article
    $tableau=$tableauxRepository->find($id);
    // $detail_commande= new DetailCommande ();

    // modifie 
    $tableau->setVendu(true);
    $manager->persist($tableau);
    
    // $detail_commande->setCommande($commande);
    // $detail_commande->setTableaux($tableau);

    // // $detail_commande->setTitre($tableau->getTitre());
    // // $detail_commande->setAuteur($tableau->getAuteur());
    // // $detail_commande->setPrix($tableau->getPrix());
    // $manager->persist($detail_commande);



    $manager->flush();
        
        $panier->SupprimerOeuvrePanier($id);
        return $this->redirectToRoute('panier');
    
    }
    /**
     * @Route("user/facture", name="facture")
     */
     public function facture(Panier $panier ): Response
     {  
    //     $user= $this->getUser();
    //     $mailproprietaire = (new Email())
    //     ->from()
    //     ->to('you@example.com')
    //     //->cc('cc@example.com')
    //     //->bcc('bcc@example.com')
    //     //->replyTo('fabien@example.com')
    //     //->priority(Email::PRIORITY_HIGH)
    //     ->subject('Time for Symfony Mailer!')
    //     ->text('Sending emails is fun again!')
    //     ->html('<p>See Twig integration for better HTML integration!</p>');

    // $mailer->send($email);
    
    // $message = (new Email())
    // ->from($email)
    // ->to()

       return $this->render('achat/index.html.twig', [
          'panier' => $panier,
            
      ]);
    }
    
}

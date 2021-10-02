<?php

namespace App\Controller;

use App\Classes\Panier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\RegistrationFormType;
use App\Entity\User;
use App\Repository\TableauxRepository;

    /**
     * @Route("/user")
     */

class ProfilController extends AbstractController
{
    /**
     * @Route("/achats", name="mes_achats")
     */
    public function MesAchats(Panier $panier, TableauxRepository $tableau): Response
    {   
        $user=$this->getUser();
        
        return $this->render('profil/mes_commandes.html.twig', [
            'tableau'=>$tableau->findAll(),
            'user' => $user,
            'panier'=>$panier->afficheDetailPanier(),
        
        ]);
    }



    /**
     * @Route("/modifier-profil", name="edit_register")
     */
    public function modifierRegister( Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
    $user=$this->getUser();
    if (!$user) {
        return $this-> redirectToRoute('home');
    }
// Je créer formulaire selon le registrationFormType
        $form = $this->createForm(RegistrationFormType::class, $user);
        // je récupère données du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('home');
        }

        return $this->render('profil/modifier_register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    
     /**
     * @Route("/supprimer-profil", name="delete_profil")
     */


    public function deleteProfil(User $user): Response
    {
        $user=$this->getUser();
        if (!$user) {
            return $this-> redirectToRoute('home');
        }
        $user->setBanni(true);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('logout');
    }
}

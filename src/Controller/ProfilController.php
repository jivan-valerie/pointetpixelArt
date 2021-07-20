<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     */
    public function index(): Response
    {
        $user=$this->getUser();
        return $this->render('profil/index.html.twig', [
            'user' => $user
          
        ]);
    }
     /**
     * @Route("/modifier-profil", name="edit_register")
     */
    public function modifierRegister(UserRepository $userRepository, Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
       $user=$this->getUser();// $user = $userRepository->find($id);
       if (!$user) {
           return $this-> redirectToRoute('home');
       }
       
        
        $form = $this->createForm(RegistrationFormType::class, $user);
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

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
     /**
     * @Route("/supprimer-profil", name="delete_profil")
     */

     
    public function deleteProfil(EntityManagerInterface $manager): Response
    {
        $user=$this->getUser();
  
        $manager->remove($user);
        
        $manager->flush();

        return $this->redirectToRoute('logout');
    }
}

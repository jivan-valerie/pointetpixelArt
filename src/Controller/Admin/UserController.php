<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Form\RegistrationFormType;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("admin/")
 */
class UserController extends AbstractController
{
    /**
     * @Route("liste-user", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new-user", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("user-show/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    
    // public function edit(Request $request, User $user): Response
    // {
    //     $form = $this->createForm(UserType::class, $user);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $this->getDoctrine()->getManager()->flush();

    //         return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('user/edit.html.twig', [
    //         'user' => $user,
    //         'form' => $form,
    //     ]);
    // }

    /**
     * @Route("user/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function modifierUser($id, UserRepository $userRepository, Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $userRepository->find($id);
    //    if (!$user) {
    //        return $this-> redirectToRoute('home');
    //    }
       
        
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            // $user->setPassword(
            //     $passwordEncoder->encodePassword(
            //         $user,
            //         $form->get('plainPassword')->getData()
            //     )
            // );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('home');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()

        ]);
    }
    

    /**
     * @Route("/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/bannir-User/{id}", name="user_bannir")
     */
    public function banUser($id, Request $request, User $user): Response
    {
        $user->setBanni(true);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }
}

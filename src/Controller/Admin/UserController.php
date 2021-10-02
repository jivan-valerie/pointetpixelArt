<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/")
 */
class UserController extends AbstractController
{
    /**
     * @Route("liste-user", name="user_index", methods={"GET"})
     */
    public function listUsers(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("user-details/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("delete/{id}", name="user_delete")
     */
    public function delete( User $user): Response
    {
        
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("bannir-User/{id}", name="user_bannir")
     */
    public function banUser(User $user): Response
    {
        $user->setBanni(true);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }
}

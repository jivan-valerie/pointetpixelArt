<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    /**
     * @Route("user/commande", name="commande")
     */
    public function index(): Response
    {
        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController',
        ]);
    }
    /**
     * @Route("/profil-tableaux", name="mes_commandes")
     */
    public function MesAchats(): Response
    {
        $user=$this->getUser();
        return $this->render('commande/index.html.twig', [
            'user' => $user
          
        ]);
    }

}

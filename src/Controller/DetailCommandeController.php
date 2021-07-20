<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailCommandeController extends AbstractController
{
    /**
     * @Route("user/detail/commande", name="detail_commande")
     */
    public function index(): Response
    {
        return $this->render('detail_commande/index.html.twig', [
            'controller_name' => 'DetailCommandeController',
        ]);
    }
}

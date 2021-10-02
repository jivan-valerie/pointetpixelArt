<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FooterController extends AbstractController
{
    /**
     * @Route("/footer/cgv", name="footer_cgv")
     */
    public function cgv(): Response
    {
        return $this->render('footer/cgv.html.twig');
    }

    /**
     * @Route("/footer/mentions", name="footer_mentions")
     */
    public function mentionsLegales(): Response
    {
        return $this->render('footer/mentions.html.twig');
    }

    /**
     * @Route("/footer/confidentialite", name="cookies")
     */
    public function confidentialité(): Response
    {
        return $this->render('footer/cookies.html.twig');
    }


}

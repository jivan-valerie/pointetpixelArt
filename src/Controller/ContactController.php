<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, MailerInterface $mailer)
    {
        $form = $this->createForm(ContactType ::class);
        
        $contact=$form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            
            $message = (new TemplatedEmail())
                ->from($contact->get('email')->getData())
                ->to('contact@PointetPixel.com')
                ->subject('message de contact')
                ->htmlTemplate('emails/email_contact.html.twig')
                ->context([
                    'nom' => $contact ->get('nom')->getData(),
                    'mail'=> $contact ->get('email')->getData(),
                    'message'=> $contact ->get('message')->getData(),
                    ]);
            $mailer->send($message);
            $this->addFlash('success', 'Vore message a été envoyé');
            return $this->redirectToRoute('contact');
        }
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
}

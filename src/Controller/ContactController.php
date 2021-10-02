<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
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
    public function index(Request $request, MailerInterface $mailer, EntityManagerInterface $manager)
    {
        // creer un formulaire à partir de builder ContactType
        $form = $this->createForm(ContactType ::class);
        // les champs sont prétraités 
        $contact=$form->handleRequest($request);
        // si le formulaire est soumis et valide
        if($form->isSubmitted() && $form->isValid()) {
            // on crée un message mail
            $message = (new TemplatedEmail())
            //du formulaire on récupère l'email donné 
                ->from($contact->get('email')->getData())
            //a contact
                ->to('contact@pointetpixel.fr')
                ->subject('message de contact')
                ->htmlTemplate('emails/email_contact.html.twig')
                ->context([
                    'nom' => $contact ->get('nom')->getData(),
                    'mail'=> $contact ->get('email')->getData(),
                    'message'=> $contact ->get('message')->getData(),
                    ]);
                    
            $manager->persist($message);
            $manager->flush();
            $mailer->send($message);
            $this->addFlash('success', 'Votre message a été envoyé');
            return $this->redirectToRoute('home');
        }
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
}

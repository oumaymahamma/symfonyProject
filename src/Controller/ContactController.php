<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function contact(Request $request, EntityManagerInterface $em): Response
    {
        // Créer une nouvelle instance de Contact-----------------------------------------------------------------------
        $contact = new Contact();

        // Créer le formulaire basé sur le formulaire ContactType
        $form = $this->createForm(ContactType::class, $contact);

        // Traiter la requête (soumission du formulaire)
        $form->handleRequest($request);

        // Vérifier si le formulaire est soumis et valide
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                // Si le formulaire est valide, on persiste l'objet Contact dans la base de données
                $em->persist($contact);
                $em->flush();

                // Ajouter un message flash pour notifier l'utilisateur du succès
                $this->addFlash('success', 'Your contact has been sent!');

                // Rediriger l'utilisateur vers la page de contact pour qu'il voie le message de succès
                return $this->redirectToRoute('contact');
            } else {
                // Ajouter un message flash pour notifier l'utilisateur d'une erreur
                $this->addFlash('error', 'There was an error with your message.');
            }
        }

        // Renvoyer la vue Twig avec le formulaire
        return $this->render('client/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

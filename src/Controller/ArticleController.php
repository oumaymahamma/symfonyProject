<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'article')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        // Création d'un nouvel article
        $article = new Article();

        // Création du formulaire lié à l'entité Article
        $form = $this->createForm(ArticleType::class, $article);

        // Gestion de la soumission du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion de l'upload de la photo
            $photo = $form->get('photo')->getData();
            if ($photo) {
                // Vérification si le fichier est valide
                try {
                    $photoName = uniqid() . '.' . $photo->guessExtension();
                    $photo->move($this->getParameter('photos_directory'), $photoName);
                    $article->setPhoto($photoName);
                } catch (\Exception $e) {
                    // Ajoute un message flash en cas d'erreur
                    $this->addFlash('danger', 'Error uploading the photo. Please try again !');
                    return $this->redirectToRoute('article');
                }
            }

            // Enregistrement de l'article dans la base de données
            $em->persist($article);
            $em->flush();

            // Ajout d'un message de succès
            $this->addFlash('success', 'Product added successfully !');
            return $this->redirectToRoute('article');
        }

        // Rendu du formulaire
        return $this->render('admin/formproduct.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

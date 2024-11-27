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
        $article = new Article();

        // Créez le formulaire
        $form = $this->createForm(ArticleType::class, $article);

        // Gère la soumission du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion de l'upload de photo
            $photo = $form->get('photo')->getData();
            if ($photo) {
                $photoName = uniqid() . '.' . $photo->guessExtension();
                $photo->move($this->getParameter('photos_directory'), $photoName);
                $article->setPhoto($photoName);
            }

            // Enregistre l'article dans la base de données
            $em->persist($article);
            $em->flush();

            $this->addFlash('success', 'Article added successfully!');
            return $this->redirectToRoute('article');
        }

        return $this->render('admin/formproduct.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;

class ArticleclientController extends AbstractController
{
    #[Route('/articleclient', name: 'articleclient')]
    public function index(ArticleRepository $articleRepository, Request $request): Response
    {
        // Récupérer le terme de recherche depuis les paramètres de requête
        $searchTerm = $request->query->get('search', '');

        // Filtrer les articles par nom si un terme est recherché
        if ($searchTerm) {
            $articles = $articleRepository->findByNameLike($searchTerm);
        } else {
            $articles = $articleRepository->findAll();
        }

        return $this->render('client/product.html.twig', [
            'articles' => $articles,
            'searchTerm' => $searchTerm,
        ]);
    }
}

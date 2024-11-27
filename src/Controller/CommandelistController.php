<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommandelistController extends AbstractController
{
    #[Route('/commandelist', name: 'commandelist')]
    public function index(): Response
    {
        return $this->render('admin/commandelist.html.twig', [
            'controller_name' => 'CommandelistController',
        ]);
    }
}

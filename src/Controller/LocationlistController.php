<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LocationlistController extends AbstractController
{
    #[Route('/locationlist', name: 'locationlist')]
    public function index(): Response
    {
        return $this->render('admin/locationlist.html.twig', [
            'controller_name' => 'LocationlistController',
        ]);
    }
}

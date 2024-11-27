<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserlistController extends AbstractController
{
    #[Route('/userlist', name: 'userlist')]
    public function index(): Response
    {
        return $this->render('admin/userlist.html.twig', [
            'controller_name' => 'UserlistController',
        ]);
    }
}

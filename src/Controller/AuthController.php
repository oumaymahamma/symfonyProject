<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    // Hardcoded credentials for demonstration
    private const USER_EMAIL = 'admin@gmail.com';
    private const USER_PASSWORD = 'password123';

    /**
     * @Route("/login", name="login", methods={"GET", "POST"})
     */
    #[Route('/login', name: 'login')]
    public function login(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            // Check if the email and password match the hardcoded values
            if ($email === self::USER_EMAIL && $password === self::USER_PASSWORD) {
                // Redirect to the dashboard on successful login
                return $this->redirectToRoute('campify');
            }

            // Add an error message if the login fails
            $this->addFlash('error', 'Invalid email or password.');
        }

        // Render the login page
        return $this->render('admin/login.html.twig');
    }

    /**
     * @Route("/compify", name="compify")
     */
    public function dashboard(): Response
    {
        return $this->render('client/index.html.twig');
    }
}

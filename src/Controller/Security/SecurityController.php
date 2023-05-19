<?php

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route(name: 'app_security_')]
class SecurityController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function register(Request $request, AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'security/login.html.twig',
            [
                'error' => $error,
                'lastUsername' => $lastUsername
            ]
        );
    }

    #[Route('/logout', name: 'logout')]
    public function logout()
    {
    }
}

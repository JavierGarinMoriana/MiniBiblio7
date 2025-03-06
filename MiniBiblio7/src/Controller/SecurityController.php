<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{

    #[Route('/entrar', name: 'app_login')]
    public function entrar(AuthenticationUtils $authenticationUtils): Response
    {

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastName = $authenticationUtils->getLastUsername();

        return $this->render('entrar.html.twig', ['last_username' => $lastName, 'error' => $error]);
    }


    #[Route(path: '/salir', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('Esto no debería ejecutarse nunca.');
    }


}

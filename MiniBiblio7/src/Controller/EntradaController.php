<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntradaController extends AbstractController
{

    #[Route('/', name: 'app_entrada')]
    public function entrada() : Response {

        return $this->render('entrada.html.twig');

    }



}
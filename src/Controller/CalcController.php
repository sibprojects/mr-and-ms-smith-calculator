<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalcController extends AbstractController
{
    #[Route('/calc', name: 'calc')]
    public function index(): Response
    {
        return $this->render('calc/calc.html.twig');
    }
}

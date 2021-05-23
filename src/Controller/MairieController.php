<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MairieController extends AbstractController
{
    #[Route('/Presentation', name: 'Presentation_maire', methods: ['GET', 'POST'])]
    public function presentation(): Response
    {

        return $this->render('mairie/maire.html.twig');
    }
    #[Route('/Son-fonctionnement', name: 'Presentation_fonctionnement', methods: ['GET', 'POST'])]
    public function fonctionnement(): Response
    {

        return $this->render('mairie/fonctionnement.html.twig');
    }
    #[Route('/Son-administration', name: 'Presentation_administration', methods: ['GET', 'POST'])]
    public function administration(): Response
    {

        return $this->render('mairie/administration.html.twig');
    }
}
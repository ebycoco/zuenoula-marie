<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\MaireRepository;
use App\Repository\PresentationMairieRepository;
use App\Repository\AdministrationDeMunicipaliteRepository;
use App\Repository\MunicipaliteRepository;
use App\Repository\OrganeDeFonctionnementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MairieController extends AbstractController
{
    #[Route('/Presentation', name: 'Presentation_maire', methods: ['GET', 'POST'])]
    public function presentation(
        MaireRepository $maireRepository,
        PresentationMairieRepository $presentationMairieRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $data = $maireRepository->findBy([], ['publishedAt' => 'DESC']);
        $maires = $paginator->paginate($data, $request->query->getint('page', 1), 6);

        $datapresentation_mairies = $presentationMairieRepository->findBy([], ['publishedAt' => 'DESC']);
        $presentation_mairies = $paginator->paginate($datapresentation_mairies, $request->query->getint('page', 1), 1);

        $mairesRece = $maireRepository->findRecent(True);
        return $this->render('mairie/maire.html.twig', [
            'maires' => $maires,
            'mairesRece' => $mairesRece,
            'presentation_mairies' => $presentation_mairies,
        ]);
    }
    #[Route('/Son-fonctionnement', name: 'Presentation_fonctionnement', methods: ['GET', 'POST'])]
    public function fonctionnement(
        OrganeDeFonctionnementRepository $organeDeFonctionnementRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $organeDeFonctionnements = $organeDeFonctionnementRepository->findAll();

        return $this->render('mairie/fonctionnement.html.twig', [
            'organeDeFonctionnements' => $organeDeFonctionnements,
        ]);
    }
    #[Route('/Son-administration', name: 'Presentation_administration', methods: ['GET', 'POST'])]
    public function administration(
        AdministrationDeMunicipaliteRepository $administrationDeMunicipaliteRepository,
        MunicipaliteRepository $MunicipaliteRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $administration_de_municipalites = $administrationDeMunicipaliteRepository->findAll();
        $data = $MunicipaliteRepository->findBy([], ['publishedAt' => 'DESC']);
        $municipalites = $paginator->paginate($data, $request->query->getint('page', 1), 1);

        return $this->render('mairie/administration.html.twig', [
            'administration_de_municipalites' => $administration_de_municipalites,
            'municipalites' => $municipalites,
        ]);
    }
}
<?php

namespace App\Controller\Admin;

use App\Entity\AdministrationDeMunicipalite;
use App\Form\AdministrationDeMunicipaliteType;
use App\Repository\AdministrationDeMunicipaliteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/administration-de-municipalite', name: 'admin_')]
class AdminAdministrationDeMunicipaliteController extends AbstractController
{
    #[Route('/', name: 'administration_de_municipalite_index', methods: ['GET'])]
    public function index(
        AdministrationDeMunicipaliteRepository $administrationDeMunicipaliteRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $data = $administrationDeMunicipaliteRepository->findBy([], ['publishedAt' => 'DESC']);
        $administration_de_municipalites = $paginator->paginate($data, $request->query->getint('page', 1), 6);
        return $this->render('admin/administration_de_municipalite/index.html.twig', [
            'administration_de_municipalites' => $administration_de_municipalites,
        ]);
    }

    #[Route('/new', name: 'administration_de_municipalite_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $administrationDeMunicipalite = new AdministrationDeMunicipalite();
        $form = $this->createForm(AdministrationDeMunicipaliteType::class, $administrationDeMunicipalite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $administrationDeMunicipalite->setUser($this->getUser());
            $entityManager->persist($administrationDeMunicipalite);
            $entityManager->flush();
            $this->addFlash('success', 'Ajouter avec success !');
            return $this->redirectToRoute('admin_administration_de_municipalite_index');
        }

        return $this->render('admin/administration_de_municipalite/new.html.twig', [
            'administration_de_municipalite' => $administrationDeMunicipalite,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'administration_de_municipalite_show', methods: ['GET'])]
    public function show(AdministrationDeMunicipalite $administrationDeMunicipalite): Response
    {
        return $this->render('admin/administration_de_municipalite/show.html.twig', [
            'administration_de_municipalite' => $administrationDeMunicipalite,
        ]);
    }

    #[Route('/{id}/edit', name: 'administration_de_municipalite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AdministrationDeMunicipalite $administrationDeMunicipalite): Response
    {
        $form = $this->createForm(AdministrationDeMunicipaliteType::class, $administrationDeMunicipalite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('info', 'Votre modification a été effectué avec success !');
            return $this->redirectToRoute('admin_administration_de_municipalite_index');
        }

        return $this->render('admin/administration_de_municipalite/edit.html.twig', [
            'administration_de_municipalite' => $administrationDeMunicipalite,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'administration_de_municipalite_delete', methods: ['POST'])]
    public function delete(Request $request, AdministrationDeMunicipalite $administrationDeMunicipalite): Response
    {
        if ($this->isCsrfTokenValid('delete' . $administrationDeMunicipalite->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($administrationDeMunicipalite);
            $entityManager->flush();
        }
        $this->addFlash('success', 'Supprimer avec success !');
        return $this->redirectToRoute('admin_administration_de_municipalite_index');
    }
}
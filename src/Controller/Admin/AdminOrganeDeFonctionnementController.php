<?php

namespace App\Controller\Admin;

use App\Entity\OrganeDeFonctionnement;
use App\Form\OrganeDeFonctionnementType;
use App\Repository\OrganeDeFonctionnementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/organe-de-fonctionnement', name: 'admin_')]
class AdminOrganeDeFonctionnementController extends AbstractController
{
    #[Route('/', name: 'organe_de_fonctionnement_index', methods: ['GET'])]
    public function index(
        OrganeDeFonctionnementRepository $organeDeFonctionnementRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $data = $organeDeFonctionnementRepository->findBy([], ['publishedAt' => 'DESC']);
        $organeDeFonctionnements = $paginator->paginate($data, $request->query->getint('page', 1), 6);
        return $this->render('admin/organe_de_fonctionnement/index.html.twig', [
            'organe_de_fonctionnements' => $organeDeFonctionnements,
        ]);
    }

    #[Route('/new', name: 'organe_de_fonctionnement_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $organeDeFonctionnement = new OrganeDeFonctionnement();
        $form = $this->createForm(OrganeDeFonctionnementType::class, $organeDeFonctionnement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $organeDeFonctionnement->setUser($this->getUser());
            $entityManager->persist($organeDeFonctionnement);
            $entityManager->flush();
            $this->addFlash('success', 'Ajouter avec success !');
            return $this->redirectToRoute('admin_organe_de_fonctionnement_index');
        }

        return $this->render('admin/organe_de_fonctionnement/new.html.twig', [
            'organe_de_fonctionnement' => $organeDeFonctionnement,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'organe_de_fonctionnement_show', methods: ['GET'])]
    public function show(OrganeDeFonctionnement $organeDeFonctionnement): Response
    {
        return $this->render('admin/organe_de_fonctionnement/show.html.twig', [
            'organe_de_fonctionnement' => $organeDeFonctionnement,
        ]);
    }

    #[Route('/{id}/edit', name: 'organe_de_fonctionnement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, OrganeDeFonctionnement $organeDeFonctionnement): Response
    {
        $form = $this->createForm(OrganeDeFonctionnementType::class, $organeDeFonctionnement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('info', 'Votre modification a été effectué avec success !');
            return $this->redirectToRoute('admin_organe_de_fonctionnement_index');
        }

        return $this->render('admin/organe_de_fonctionnement/edit.html.twig', [
            'organe_de_fonctionnement' => $organeDeFonctionnement,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'organe_de_fonctionnement_delete', methods: ['POST'])]
    public function delete(Request $request, OrganeDeFonctionnement $organeDeFonctionnement): Response
    {
        if ($this->isCsrfTokenValid('delete' . $organeDeFonctionnement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($organeDeFonctionnement);
            $entityManager->flush();
        }
        $this->addFlash('success', 'Supprimer avec success !');
        return $this->redirectToRoute('admin_organe_de_fonctionnement_index');
    }
}
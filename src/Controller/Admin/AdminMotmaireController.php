<?php

namespace App\Controller\Admin;

use App\Entity\Motmaire;
use App\Form\MotmaireType;
use App\Repository\MotmaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/motmaire', name: 'admin_')]
class AdminMotmaireController extends AbstractController
{
    #[Route('/', name: 'motmaire_index', methods: ['GET'])]
    public function index(
        MotmaireRepository $motmaireRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $data = $motmaireRepository->findBy([], ['publishedAt' => 'DESC']);
        $motmaires = $paginator->paginate($data, $request->query->getint('page', 1), 6);
        return $this->render('admin/motmaire/index.html.twig', [
            'motmaires' => $motmaires,
        ]);
    }

    #[Route('/new', name: 'motmaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $motmaire = new Motmaire();
        $form = $this->createForm(MotmaireType::class, $motmaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $motmaire->setUser($this->getUser());
            $entityManager->persist($motmaire);
            $entityManager->flush();
            $this->addFlash('success', 'Ajouter avec success !');
            return $this->redirectToRoute('admin_motmaire_index');
        }
        return $this->render('admin/motmaire/new.html.twig', [
            'motmaire' => $motmaire,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'motmaire_show', methods: ['GET'])]
    public function show(Motmaire $motmaire): Response
    {
        return $this->render('admin/motmaire/show.html.twig', [
            'motmaire' => $motmaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'motmaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Motmaire $motmaire): Response
    {
        $form = $this->createForm(MotmaireType::class, $motmaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('info', 'Votre modification a été effectué avec success !');
            return $this->redirectToRoute('admin_motmaire_index');
        }
        return $this->render('admin/motmaire/edit.html.twig', [
            'motmaire' => $motmaire,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'motmaire_delete', methods: ['POST'])]
    public function delete(Request $request, Motmaire $motmaire): Response
    {
        if ($this->isCsrfTokenValid('delete' . $motmaire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($motmaire);
            $entityManager->flush();
        }
        $this->addFlash('success', 'Supprimer avec success !');
        return $this->redirectToRoute('admin_motmaire_index');
    }
}
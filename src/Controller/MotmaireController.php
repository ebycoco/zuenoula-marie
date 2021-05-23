<?php

namespace App\Controller;

use App\Entity\Motmaire;
use App\Form\MotmaireType;
use App\Repository\MotmaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/motmaire')]
class MotmaireController extends AbstractController
{
    #[Route('/', name: 'motmaire_index', methods: ['GET'])]
    public function index(MotmaireRepository $motmaireRepository): Response
    {
        return $this->render('motmaire/index.html.twig', [
            'motmaires' => $motmaireRepository->findAll(),
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
            $entityManager->persist($motmaire);
            $entityManager->flush();

            return $this->redirectToRoute('motmaire_index');
        }

        return $this->render('motmaire/new.html.twig', [
            'motmaire' => $motmaire,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'motmaire_show', methods: ['GET'])]
    public function show(Motmaire $motmaire): Response
    {
        return $this->render('motmaire/show.html.twig', [
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

            return $this->redirectToRoute('motmaire_index');
        }

        return $this->render('motmaire/edit.html.twig', [
            'motmaire' => $motmaire,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'motmaire_delete', methods: ['POST'])]
    public function delete(Request $request, Motmaire $motmaire): Response
    {
        if ($this->isCsrfTokenValid('delete'.$motmaire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($motmaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('motmaire_index');
    }
}

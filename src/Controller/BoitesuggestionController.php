<?php

namespace App\Controller;

use App\Entity\Boitesuggestion;
use App\Form\BoitesuggestionType;
use App\Repository\BoitesuggestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/boitesuggestion')]
class BoitesuggestionController extends AbstractController
{
    #[Route('/', name: 'boitesuggestion_index', methods: ['GET'])]
    public function index(BoitesuggestionRepository $boitesuggestionRepository): Response
    {
        return $this->render('boitesuggestion/index.html.twig', [
            'boitesuggestions' => $boitesuggestionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'boitesuggestion_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $boitesuggestion = new Boitesuggestion();
        $form = $this->createForm(BoitesuggestionType::class, $boitesuggestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($boitesuggestion);
            $entityManager->flush();

            return $this->redirectToRoute('boitesuggestion_index');
        }

        return $this->render('boitesuggestion/new.html.twig', [
            'boitesuggestion' => $boitesuggestion,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'boitesuggestion_show', methods: ['GET'])]
    public function show(Boitesuggestion $boitesuggestion): Response
    {
        return $this->render('boitesuggestion/show.html.twig', [
            'boitesuggestion' => $boitesuggestion,
        ]);
    }

    #[Route('/{id}/edit', name: 'boitesuggestion_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Boitesuggestion $boitesuggestion): Response
    {
        $form = $this->createForm(BoitesuggestionType::class, $boitesuggestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('boitesuggestion_index');
        }

        return $this->render('boitesuggestion/edit.html.twig', [
            'boitesuggestion' => $boitesuggestion,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'boitesuggestion_delete', methods: ['POST'])]
    public function delete(Request $request, Boitesuggestion $boitesuggestion): Response
    {
        if ($this->isCsrfTokenValid('delete'.$boitesuggestion->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($boitesuggestion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('boitesuggestion_index');
    }
}

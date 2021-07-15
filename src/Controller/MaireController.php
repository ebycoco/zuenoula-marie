<?php

namespace App\Controller;

use App\Entity\Maire;
use App\Form\MaireType;
use App\Repository\MaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/maire')]
class MaireController extends AbstractController
{
    #[Route('/', name: 'maire_index', methods: ['GET'])]
    public function index(MaireRepository $maireRepository): Response
    {
        return $this->render('maire/index.html.twig', [
            'maires' => $maireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'maire_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $maire = new Maire();
        $form = $this->createForm(MaireType::class, $maire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($maire);
            $entityManager->flush();

            return $this->redirectToRoute('maire_index');
        }

        return $this->render('maire/new.html.twig', [
            'maire' => $maire,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'maire_show', methods: ['GET'])]
    public function show(Maire $maire): Response
    {
        return $this->render('maire/show.html.twig', [
            'maire' => $maire,
        ]);
    }

    #[Route('/{id}/edit', name: 'maire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Maire $maire): Response
    {
        $form = $this->createForm(MaireType::class, $maire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('maire_index');
        }

        return $this->render('maire/edit.html.twig', [
            'maire' => $maire,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'maire_delete', methods: ['POST'])]
    public function delete(Request $request, Maire $maire): Response
    {
        if ($this->isCsrfTokenValid('delete'.$maire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($maire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('maire_index');
    }
}

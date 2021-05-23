<?php

namespace App\Controller;

use App\Entity\Coin;
use App\Form\CoinType;
use App\Repository\CoinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/coin')]
class CoinController extends AbstractController
{
    #[Route('/', name: 'coin_index', methods: ['GET'])]
    public function index(CoinRepository $coinRepository): Response
    {
        return $this->render('coin/index.html.twig', [
            'coins' => $coinRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'coin_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $coin = new Coin();
        $form = $this->createForm(CoinType::class, $coin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($coin);
            $entityManager->flush();

            return $this->redirectToRoute('coin_index');
        }

        return $this->render('coin/new.html.twig', [
            'coin' => $coin,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'coin_show', methods: ['GET'])]
    public function show(Coin $coin): Response
    {
        return $this->render('coin/show.html.twig', [
            'coin' => $coin,
        ]);
    }

    #[Route('/{id}/edit', name: 'coin_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Coin $coin): Response
    {
        $form = $this->createForm(CoinType::class, $coin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('coin_index');
        }

        return $this->render('coin/edit.html.twig', [
            'coin' => $coin,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'coin_delete', methods: ['POST'])]
    public function delete(Request $request, Coin $coin): Response
    {
        if ($this->isCsrfTokenValid('delete'.$coin->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($coin);
            $entityManager->flush();
        }

        return $this->redirectToRoute('coin_index');
    }
}

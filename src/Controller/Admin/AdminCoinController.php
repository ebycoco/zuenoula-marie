<?php

namespace App\Controller\Admin;

use App\Entity\Coin;
use App\Form\CoinType;
use App\Repository\CoinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/coin', name: 'admin_')]
class AdminCoinController extends AbstractController
{
    #[Route('/', name: 'coin_index', methods: ['GET'])]
    public function index(
        CoinRepository $coinRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $data = $coinRepository->findBy([], ['publishedAt' => 'DESC']);
        $coins = $paginator->paginate($data, $request->query->getint('page', 1), 6);
        return $this->render('admin/coin/index.html.twig', [
            'coins' => $coins,
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
            $coin->setUser($this->getUser());
            $entityManager->persist($coin);
            $entityManager->flush();
            $this->addFlash('success', 'Ajouter avec success !');
            return $this->redirectToRoute('admin_coin_index');
        }

        return $this->render('admin/coin/new.html.twig', [
            'coin' => $coin,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'coin_show', methods: ['GET'])]
    public function show(Coin $coin): Response
    {
        return $this->render('admin/coin/show.html.twig', [
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
            $this->addFlash('info', 'Le coin a été modifié avec success !');
            return $this->redirectToRoute('admin_coin_index');
        }

        return $this->render('admin/coin/edit.html.twig', [
            'coin' => $coin,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'coin_delete', methods: ['POST'])]
    public function delete(Request $request, Coin $coin): Response
    {
        if ($this->isCsrfTokenValid('delete' . $coin->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($coin);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_coin_index');
    }
}
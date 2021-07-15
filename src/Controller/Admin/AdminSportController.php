<?php

namespace App\Controller\Admin;

use App\Entity\Sport;
use App\Form\SportType;
use App\Repository\SportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/sport', name: 'admin_')]
class AdminSportController extends AbstractController
{
    #[Route('/', name: 'sport_index', methods: ['GET'])]
    public function index(
        SportRepository $sportRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $data = $sportRepository->findBy([], ['publishedAt' => 'DESC']);
        $sports = $paginator->paginate($data, $request->query->getint('page', 1), 6);
        return $this->render('admin/sport/index.html.twig', [
            'sports' => $sports,
        ]);
    }

    #[Route('/new', name: 'sport_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $sport = new Sport();
        $form = $this->createForm(SportType::class, $sport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $sport->setUser($this->getUser());
            $entityManager->persist($sport);
            $entityManager->flush();
            $this->addFlash('success', 'Ajouter avec success !');
            return $this->redirectToRoute('admin_sport_index');
        }

        return $this->render('admin/sport/new.html.twig', [
            'sport' => $sport,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'sport_show', methods: ['GET'])]
    public function show(Sport $sport): Response
    {
        return $this->render('admin/sport/show.html.twig', [
            'sport' => $sport,
        ]);
    }

    #[Route('/{id}/edit', name: 'sport_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Sport $sport): Response
    {
        $form = $this->createForm(SportType::class, $sport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('info', 'Votre modification a été effectué avec success !');
            return $this->redirectToRoute('admin_sport_index');
        }
        return $this->render('admin/sport/edit.html.twig', [
            'sport' => $sport,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'sport_delete', methods: ['POST'])]
    public function delete(Request $request, Sport $sport): Response
    {
        if ($this->isCsrfTokenValid('delete' . $sport->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sport);
            $entityManager->flush();
        }
        $this->addFlash('success', 'Supprimer avec success !');
        return $this->redirectToRoute('admin_sport_index');
    }
}
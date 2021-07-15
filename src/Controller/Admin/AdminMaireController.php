<?php

namespace App\Controller\Admin;

use App\Entity\Maire;
use App\Form\MaireType;
use App\Repository\MaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/maire', name: 'admin_')]
class AdminMaireController extends AbstractController
{
    #[Route('/', name: 'maire_index', methods: ['GET'])]
    public function index(
        MaireRepository $maireRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $data = $maireRepository->findBy([], ['publishedAt' => 'DESC']);
        $maires = $paginator->paginate($data, $request->query->getint('page', 1), 6);
        return $this->render('admin/maire/index.html.twig', [
            'maires' => $maires,
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
            $maire->setUser($this->getUser());
            $entityManager->persist($maire);
            $entityManager->flush();
            $this->addFlash('success', 'Ajouter avec success !');
            return $this->redirectToRoute('admin_maire_index');
        }

        return $this->render('admin/maire/new.html.twig', [
            'maire' => $maire,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'maire_show', methods: ['GET'])]
    public function show(Maire $maire): Response
    {
        return $this->render('admin/maire/show.html.twig', [
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
            $this->addFlash('info', 'Votre modification a été effectué avec success !');
            return $this->redirectToRoute('admin_maire_index');
        }

        return $this->render('admin/maire/edit.html.twig', [
            'maire' => $maire,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'maire_delete', methods: ['POST'])]
    public function delete(Request $request, Maire $maire): Response
    {
        if ($this->isCsrfTokenValid('delete' . $maire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($maire);
            $entityManager->flush();
        }
        $this->addFlash('success', 'Supprimer avec success !');
        return $this->redirectToRoute('admin_maire_index');
    }
}
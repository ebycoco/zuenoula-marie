<?php

namespace App\Controller\Admin;

use App\Entity\GrandeSurface;
use App\Form\GrandeSurfaceType;
use App\Repository\GrandeSurfaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/grande-surface', name: 'admin_')]
class AdminGrandeSurfaceController extends AbstractController
{
    #[Route('/', name: 'grande_surface_index', methods: ['GET'])]
    public function index(
        GrandeSurfaceRepository $grandeSurfaceRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $data = $grandeSurfaceRepository->findBy([], ['publishedAt' => 'DESC']);
        $grande_surfaces = $paginator->paginate($data, $request->query->getint('page', 1), 6);
        return $this->render('admin/grande_surface/index.html.twig', [
            'grande_surfaces' => $grande_surfaces,
        ]);
    }

    #[Route('/new', name: 'grande_surface_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $grandeSurface = new GrandeSurface();
        $form = $this->createForm(GrandeSurfaceType::class, $grandeSurface);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $grandeSurface->setUser($this->getUser());
            $entityManager->persist($grandeSurface);
            $entityManager->flush();
            $this->addFlash('success', 'Ajouter avec success !');
            return $this->redirectToRoute('admin_grande_surface_index');
        }

        return $this->render('admin/grande_surface/new.html.twig', [
            'grande_surface' => $grandeSurface,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'grande_surface_show', methods: ['GET'])]
    public function show(GrandeSurface $grandeSurface): Response
    {
        return $this->render('admin/grande_surface/show.html.twig', [
            'grande_surface' => $grandeSurface,
        ]);
    }

    #[Route('/{id}/edit', name: 'grande_surface_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, GrandeSurface $grandeSurface): Response
    {
        $form = $this->createForm(GrandeSurfaceType::class, $grandeSurface);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('info', 'Votre modification a été effectué avec success !');
            return $this->redirectToRoute('admin_grande_surface_index');
        }

        return $this->render('admin/grande_surface/edit.html.twig', [
            'grande_surface' => $grandeSurface,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'grande_surface_delete', methods: ['POST'])]
    public function delete(Request $request, GrandeSurface $grandeSurface): Response
    {
        if ($this->isCsrfTokenValid('delete' . $grandeSurface->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($grandeSurface);
            $entityManager->flush();
        }
        $this->addFlash('success', 'Supprimer avec success !');
        return $this->redirectToRoute('admin_grande_surface_index');
    }
}
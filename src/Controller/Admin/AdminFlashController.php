<?php

namespace App\Controller\Admin;

use App\Entity\Flash;
use App\Form\FlashType;
use App\Repository\FlashRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/flash', name: 'admin_')]
class AdminFlashController extends AbstractController
{
    #[Route('/', name: 'flash_index', methods: ['GET'])]
    public function index(
        FlashRepository $flashRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $data = $flashRepository->findBy([], ['publishedAt' => 'DESC']);
        $flashes = $paginator->paginate($data, $request->query->getint('page', 1), 6);
        return $this->render('admin/flash/index.html.twig', [
            'flashes' => $flashes,
        ]);
    }

    #[Route('/new', name: 'flash_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $flash = new Flash();
        $form = $this->createForm(FlashType::class, $flash);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $flash->setUser($this->getUser());
            $entityManager->persist($flash);
            $entityManager->flush();
            $this->addFlash('success', 'Ajouter avec success !');
            return $this->redirectToRoute('admin_flash_index');
        }

        return $this->render('admin/flash/new.html.twig', [
            'flash' => $flash,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'flash_show', methods: ['GET'])]
    public function show(Flash $flash): Response
    {
        return $this->render('admin/flash/show.html.twig', [
            'flash' => $flash,
        ]);
    }

    #[Route('/{id}/edit', name: 'flash_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Flash $flash): Response
    {
        $form = $this->createForm(FlashType::class, $flash);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('info', 'Le flash a été modifié avec success !');
            return $this->redirectToRoute('admin_flash_index');
        }

        return $this->render('admin/flash/edit.html.twig', [
            'flash' => $flash,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'flash_delete', methods: ['POST'])]
    public function delete(Request $request, Flash $flash): Response
    {
        if ($this->isCsrfTokenValid('delete' . $flash->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($flash);
            $entityManager->flush();
        }
        $this->addFlash('success', 'Supprimer avec success !');
        return $this->redirectToRoute('admin_flash_index');
    }
}
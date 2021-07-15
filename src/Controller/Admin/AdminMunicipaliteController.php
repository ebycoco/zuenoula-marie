<?php

namespace App\Controller\Admin;

use App\Entity\Municipalite;
use App\Form\MunicipaliteType;
use App\Repository\MunicipaliteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/municipalite', name: 'admin_')]
class AdminMunicipaliteController extends AbstractController
{
    #[Route('/', name: 'municipalite_index', methods: ['GET'])]
    public function index(
        MunicipaliteRepository $municipaliteRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $data = $municipaliteRepository->findBy([], ['publishedAt' => 'DESC']);
        $municipalites = $paginator->paginate($data, $request->query->getint('page', 1), 6);
        return $this->render('admin/municipalite/index.html.twig', [
            'municipalites' => $municipalites,
        ]);
    }

    #[Route('/new', name: 'municipalite_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $municipalite = new Municipalite();
        $form = $this->createForm(MunicipaliteType::class, $municipalite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $municipalite->setUser($this->getUser());
            $entityManager->persist($municipalite);
            $entityManager->flush();
            $this->addFlash('success', 'Ajouter avec success !');
            return $this->redirectToRoute('admin_municipalite_index');
        }

        return $this->render('admin/municipalite/new.html.twig', [
            'municipalite' => $municipalite,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'municipalite_show', methods: ['GET'])]
    public function show(Municipalite $municipalite): Response
    {
        return $this->render('admin/municipalite/show.html.twig', [
            'municipalite' => $municipalite,
        ]);
    }

    #[Route('/{id}/edit', name: 'municipalite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Municipalite $municipalite): Response
    {
        $form = $this->createForm(MunicipaliteType::class, $municipalite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('info', 'Votre modification a été effectué avec success !');
            return $this->redirectToRoute('admin_municipalite_index');
        }

        return $this->render('admin/municipalite/edit.html.twig', [
            'municipalite' => $municipalite,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'municipalite_delete', methods: ['POST'])]
    public function delete(Request $request, Municipalite $municipalite): Response
    {
        if ($this->isCsrfTokenValid('delete' . $municipalite->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($municipalite);
            $entityManager->flush();
        }
        $this->addFlash('success', 'Supprimer avec success !');
        return $this->redirectToRoute('admin_municipalite_index');
    }
}
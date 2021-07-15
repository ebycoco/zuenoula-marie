<?php

namespace App\Controller\Admin;

use App\Entity\PresentationMairie;
use App\Form\PresentationMairieType;
use App\Repository\PresentationMairieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/presentation-mairie', name: 'admin_')]
class AdminPresentationMairieController extends AbstractController
{
    #[Route('/', name: 'presentation_mairie_index', methods: ['GET'])]
    public function index(
        PresentationMairieRepository $presentationMairieRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $data = $presentationMairieRepository->findBy([], ['publishedAt' => 'DESC']);
        $presentation_mairies = $paginator->paginate($data, $request->query->getint('page', 1), 6);
        return $this->render('admin/presentation_mairie/index.html.twig', [
            'presentation_mairies' => $presentation_mairies,
        ]);
    }

    #[Route('/new', name: 'presentation_mairie_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $presentationMairie = new PresentationMairie();
        $form = $this->createForm(PresentationMairieType::class, $presentationMairie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $presentationMairie->setUser($this->getUser());
            $entityManager->persist($presentationMairie);
            $entityManager->flush();
            $this->addFlash('success', 'Ajouter avec success !');
            return $this->redirectToRoute('admin_presentation_mairie_index');
        }

        return $this->render('admin/presentation_mairie/new.html.twig', [
            'presentation_mairie' => $presentationMairie,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/activation/{id}', name: 'article_activation', methods: ['GET'])]
    public function activation(PresentationMairie $PresentationMairie)
    {
        $PresentationMairie->setActive(($PresentationMairie->getActive() ? false : true));
        $em = $this->getDoctrine()->getManager();
        $em->persist($PresentationMairie);
        $em->flush();
        return new Response("true");
    }

    #[Route('/{id}', name: 'presentation_mairie_show', methods: ['GET'])]
    public function show(PresentationMairie $presentationMairie): Response
    {
        return $this->render('admin/presentation_mairie/show.html.twig', [
            'presentation_mairie' => $presentationMairie,
        ]);
    }

    #[Route('/{id}/edit', name: 'presentation_mairie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PresentationMairie $presentationMairie): Response
    {
        $form = $this->createForm(PresentationMairieType::class, $presentationMairie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('info', 'Votre modification a été effectué avec success !');
            return $this->redirectToRoute('admin_presentation_mairie_index');
        }

        return $this->render('admin/presentation_mairie/edit.html.twig', [
            'presentation_mairie' => $presentationMairie,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'presentation_mairie_delete', methods: ['POST'])]
    public function delete(Request $request, PresentationMairie $presentationMairie): Response
    {
        if ($this->isCsrfTokenValid('delete' . $presentationMairie->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($presentationMairie);
            $entityManager->flush();
        }
        $this->addFlash('success', 'Supprimer avec success !');
        return $this->redirectToRoute('admin_presentation_mairie_index');
    }
}
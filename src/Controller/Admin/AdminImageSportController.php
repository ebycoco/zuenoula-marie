<?php

namespace App\Controller\Admin;

use App\Entity\ImageSport;
use App\Form\ImageSportType;
use App\Repository\ImageSportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/image-sport', name: 'admin_')]
class AdminImageSportController extends AbstractController
{
    #[Route('/', name: 'image_sport_index', methods: ['GET'])]
    public function index(
        ImageSportRepository $imageSportRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $data = $imageSportRepository->findBy([], ['publishedAt' => 'DESC']);
        $image_sports = $paginator->paginate($data, $request->query->getint('page', 1), 6);
        return $this->render('admin/image_sport/index.html.twig', [
            'image_sports' => $image_sports,
        ]);
    }

    #[Route('/new', name: 'image_sport_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $imageSport = new ImageSport();
        $form = $this->createForm(ImageSportType::class, $imageSport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $imageSport->setUser($this->getUser());
            $entityManager->persist($imageSport);
            $entityManager->flush();
            $this->addFlash('success', 'Ajouter avec success !');

            return $this->redirectToRoute('admin_image_sport_index');
        }

        return $this->render('admin/image_sport/new.html.twig', [
            'image_sport' => $imageSport,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'image_sport_show', methods: ['GET'])]
    public function show(ImageSport $imageSport): Response
    {
        return $this->render('admin/image_sport/show.html.twig', [
            'image_sport' => $imageSport,
        ]);
    }

    #[Route('/{id}/edit', name: 'image_sport_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ImageSport $imageSport): Response
    {
        $form = $this->createForm(ImageSportType::class, $imageSport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('info', 'Votre modification a été effectué avec success !');
            return $this->redirectToRoute('admin_image_sport_index');
        }

        return $this->render('admin/image_sport/edit.html.twig', [
            'image_sport' => $imageSport,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'image_sport_delete', methods: ['POST'])]
    public function delete(Request $request, ImageSport $imageSport): Response
    {
        if ($this->isCsrfTokenValid('delete' . $imageSport->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($imageSport);
            $entityManager->flush();
        }
        $this->addFlash('success', 'Supprimer avec success !');
        return $this->redirectToRoute('admin_image_sport_index');
    }
}
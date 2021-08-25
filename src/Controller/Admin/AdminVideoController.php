<?php

namespace App\Controller\Admin;

use App\Entity\Video;
use App\Form\VideoType;
use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/video', name: 'admin_')]
class AdminVideoController extends AbstractController
{
    #[Route('/', name: 'video_index', methods: ['GET'])]
    public function index(
        VideoRepository $videoRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $data = $videoRepository->findBy([], ['publishedAt' => 'DESC']);
        $video = $paginator->paginate($data, $request->query->getint('page', 1), 6);
        return $this->render('admin/video/index.html.twig', [
            'videos' => $video,
        ]);
    }
    #[Route('/new', name: 'video_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $video = new Video();
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $video->setUser($this->getUser());
            $entityManager->persist($video);
            $entityManager->flush();
            $this->addFlash('success', 'Ajouter avec success !');
            return $this->redirectToRoute('admin_video_index');
        }

        return $this->render('admin/video/new.html.twig', [
            'video' => $video,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'video_show', methods: ['GET'])]
    public function show(Video $video): Response
    {
        return $this->render('admin/video/show.html.twig', [
            'video' => $video,
        ]);
    }

    #[Route('/{id}/edit', name: 'video_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Video $video): Response
    {
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('info', 'Votre modification a été effectué avec success !');
            return $this->redirectToRoute('admin_video_index');
        }

        return $this->render('admin/video/edit.html.twig', [
            'video' => $video,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'video_delete', methods: ['POST'])]
    public function delete(Request $request, Video $video): Response
    {
        if ($this->isCsrfTokenValid('delete' . $video->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($video);
            $entityManager->flush();
        }
        $this->addFlash('success', 'Supprimer avec success !');
        return $this->redirectToRoute('admin_video_index');
    }
}
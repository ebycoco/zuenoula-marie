<?php

namespace App\Controller\Admin;

use App\Entity\InfoService;
use App\Form\InfoServiceType;
use App\Repository\InfoServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/info-service', name: 'admin_')]
class AdminInfoServiceController extends AbstractController
{
    #[Route('/', name: 'info_service_index', methods: ['GET'])]
    public function index(
        InfoServiceRepository $infoServiceRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $data = $infoServiceRepository->findBy([], ['publishedAt' => 'DESC']);
        $info_services = $paginator->paginate($data, $request->query->getint('page', 1), 6);
        return $this->render('admin/info_service/index.html.twig', [
            'info_services' => $info_services,
        ]);
    }

    #[Route('/new', name: 'info_service_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $infoService = new InfoService();
        $form = $this->createForm(InfoServiceType::class, $infoService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $infoService->setUser($this->getUser());
            $entityManager->persist($infoService);
            $entityManager->flush();
            $this->addFlash('success', 'Ajouter avec success !');

            return $this->redirectToRoute('admin_info_service_index');
        }

        return $this->render('admin/info_service/new.html.twig', [
            'info_service' => $infoService,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'info_service_show', methods: ['GET'])]
    public function show(InfoService $infoService): Response
    {
        return $this->render('admin/info_service/show.html.twig', [
            'info_service' => $infoService,
        ]);
    }

    #[Route('/{id}/edit', name: 'info_service_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, InfoService $infoService): Response
    {
        $form = $this->createForm(InfoServiceType::class, $infoService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('info', 'Votre modification a été effectué avec success !');
            return $this->redirectToRoute('admin_info_service_index');
        }

        return $this->render('admin/info_service/edit.html.twig', [
            'info_service' => $infoService,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'info_service_delete', methods: ['POST'])]
    public function delete(Request $request, InfoService $infoService): Response
    {
        if ($this->isCsrfTokenValid('delete' . $infoService->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($infoService);
            $entityManager->flush();
        }
        $this->addFlash('success', 'Supprimer avec success !');
        return $this->redirectToRoute('admin_info_service_index');
    }
}
<?php

namespace App\Controller\Admin;

use App\Entity\Slider;
use App\Form\SliderType;
use App\Repository\SliderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/slider', name: 'admin_')]
class AdminSliderController extends AbstractController
{
    #[Route('/', name: 'slider_index', methods: ['GET'])]
    public function index(
        SliderRepository $sliderRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $data = $sliderRepository->findBy([], ['publishedAt' => 'DESC']);
        $sliders = $paginator->paginate($data, $request->query->getint('page', 1), 6);
        return $this->render('admin/slider/index.html.twig', [
            'sliders' => $sliders,
        ]);
    }

    #[Route('/new', name: 'slider_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $slider = new Slider();
        $form = $this->createForm(SliderType::class, $slider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $slider->setUser($this->getUser());
            $entityManager->persist($slider);
            $entityManager->flush();
            $this->addFlash('success', 'Ajouter avec success !');
            return $this->redirectToRoute('admin_slider_index');
        }

        return $this->render('admin/slider/new.html.twig', [
            'slider' => $slider,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'slider_show', methods: ['GET'])]
    public function show(Slider $slider): Response
    {
        return $this->render('admin/slider/show.html.twig', [
            'slider' => $slider,
        ]);
    }

    #[Route('/{id}/edit', name: 'slider_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Slider $slider): Response
    {
        $form = $this->createForm(SliderType::class, $slider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('info', 'Votre modification a été effectué avec success !');
            return $this->redirectToRoute('admin_slider_index');
        }

        return $this->render('admin/slider/edit.html.twig', [
            'slider' => $slider,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'slider_delete', methods: ['POST'])]
    public function delete(Request $request, Slider $slider): Response
    {
        if ($this->isCsrfTokenValid('delete' . $slider->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($slider);
            $entityManager->flush();
        }
        $this->addFlash('success', 'Supprimer avec success !');
        return $this->redirectToRoute('admin_slider_index');
    }
}
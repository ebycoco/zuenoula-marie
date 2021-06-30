<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'admin_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository,): Response
    {
        $articles = $articleRepository->findAll();
        $articlesValide = $articleRepository->findValide(true);
        $articlesInValide = $articleRepository->findInValide(false);
        return $this->render('admin/dashboard.html.twig', [
            'articles' => $articles,
            'articlesValide' => $articlesValide,
            'articlesInValide' => $articlesInValide
        ]);
    }
    #[Route('/profile', name: 'admin_profil', methods: ['GET', 'POST'])]
    public function profil(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user->setModif(($user->getModif() ? false : true));
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Votre mise à jour a été modifier!');
            return $this->redirectToRoute('admin_profil');
        }
        return $this->render('admin/profile.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }
}
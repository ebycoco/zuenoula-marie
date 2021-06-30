<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/article')]
class ArticleController extends AbstractController
{
    #[Route('/liste-article', name: 'article_liste', methods: ['GET'])]
    public function listearticle(
        ArticleRepository $articleRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $data = $articleRepository->findValide(True);
        $articles = $paginator->paginate($data, $request->query->getint('page', 1), 12);
        return $this->render('article/article.html.twig', [
            'articles' => $articles,
        ]);
    }
    #[Route('/article/{slug}', name: 'article_detail', methods: ['GET'])]
    public function detailarticle(Article $article,): Response
    {
        return $this->render('article/article_detail.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/{id}', name: 'article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }
}
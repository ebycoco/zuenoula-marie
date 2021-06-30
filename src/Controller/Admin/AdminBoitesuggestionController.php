<?php

namespace App\Controller\Admin;

use App\Entity\Boitesuggestion;
use App\Form\BoitesuggestionType;
use App\Repository\BoitesuggestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/boitesuggestion', name: 'admin_')]
class AdminBoitesuggestionController extends AbstractController
{
    #[Route('/', name: 'boitesuggestion_index', methods: ['GET'])]
    public function index(
        BoitesuggestionRepository $boitesuggestionRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $data = $boitesuggestionRepository->findBy([], ['publishedAt' => 'DESC']);
        $boitesuggestions = $paginator->paginate($data, $request->query->getint('page', 1), 6);
        return $this->render('admin/boitesuggestion/index.html.twig', [
            'boitesuggestions' => $boitesuggestions,
        ]);
    }


    #[Route('/{id}', name: 'boitesuggestion_delete', methods: ['POST'])]
    public function delete(Request $request, Boitesuggestion $boitesuggestion): Response
    {
        if ($this->isCsrfTokenValid('delete' . $boitesuggestion->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($boitesuggestion);
            $entityManager->flush();
        }
        $this->addFlash('warning', 'Vous venez de supprimer le message !');
        return $this->redirectToRoute('admin_boitesuggestion_index');
    }
}
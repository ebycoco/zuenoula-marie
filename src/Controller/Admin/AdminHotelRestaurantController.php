<?php

namespace App\Controller\Admin;

use App\Entity\HotelRestaurant;
use App\Form\HotelRestaurantType;
use App\Repository\HotelRestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/hotel-restaurant', name: 'admin_')]
class AdminHotelRestaurantController extends AbstractController
{
    #[Route('/', name: 'hotel_restaurant_index', methods: ['GET'])]
    public function index(
        HotelRestaurantRepository $hotelRestaurantRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $data = $hotelRestaurantRepository->findBy([], ['publishedAt' => 'DESC']);
        $hotel_restaurants = $paginator->paginate($data, $request->query->getint('page', 1), 6);
        return $this->render('admin/hotel_restaurant/index.html.twig', [
            'hotel_restaurants' => $hotel_restaurants,
        ]);
    }

    #[Route('/new', name: 'hotel_restaurant_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $hotelRestaurant = new HotelRestaurant();
        $form = $this->createForm(HotelRestaurantType::class, $hotelRestaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $hotelRestaurant->setUser($this->getUser());
            $entityManager->persist($hotelRestaurant);
            $entityManager->flush();
            $this->addFlash('success', 'Ajouter avec success !');

            return $this->redirectToRoute('admin_hotel_restaurant_index');
        }

        return $this->render('admin/hotel_restaurant/new.html.twig', [
            'hotel_restaurant' => $hotelRestaurant,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'hotel_restaurant_show', methods: ['GET'])]
    public function show(HotelRestaurant $hotelRestaurant): Response
    {
        return $this->render('admin/hotel_restaurant/show.html.twig', [
            'hotel_restaurant' => $hotelRestaurant,
        ]);
    }

    #[Route('/{id}/edit', name: 'hotel_restaurant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, HotelRestaurant $hotelRestaurant): Response
    {
        $form = $this->createForm(HotelRestaurantType::class, $hotelRestaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('info', 'Votre modification a été effectué avec success !');
            return $this->redirectToRoute('admin_hotel_restaurant_index');
        }

        return $this->render('admin/hotel_restaurant/edit.html.twig', [
            'hotel_restaurant' => $hotelRestaurant,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'hotel_restaurant_delete', methods: ['POST'])]
    public function delete(Request $request, HotelRestaurant $hotelRestaurant): Response
    {
        if ($this->isCsrfTokenValid('delete' . $hotelRestaurant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($hotelRestaurant);
            $entityManager->flush();
        }
        $this->addFlash('success', 'Supprimer avec success !');
        return $this->redirectToRoute('admin_hotel_restaurant_index');
    }
}
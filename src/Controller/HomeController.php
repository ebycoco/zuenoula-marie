<?php

namespace App\Controller;

use App\Entity\Boitesuggestion;
use App\Entity\Contact;
use App\Form\BoitesuggestionType;
use App\Form\ContactType;
use App\Repository\ArticleRepository;
use App\Repository\CoinRepository;
use App\Repository\FlashRepository;
use App\Repository\HotelRestaurantRepository;
use App\Repository\MotmaireRepository;
use App\Repository\SliderRepository;
use App\Repository\VideoRepository;
use App\Repository\SportRepository;
use App\Repository\ImageSportRepository;
use Knp\Component\Pager\PaginatorInterface;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        ArticleRepository $articleRepository,
        SliderRepository $sliderRepository,
        MotmaireRepository $motmaireRepository,
        CoinRepository $coinRepository,
        FlashRepository $flashRepository,
        VideoRepository $videoRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $articlesRece = $articleRepository->findRecent(True);
        $data = $articleRepository->findValide(True);
        $articles = $paginator->paginate($data, $request->query->getint('page', 1), 6);

        $dataflash = $flashRepository->findBy([], ['publishedAt' => 'DESC']);
        $flashes = $paginator->paginate($dataflash, $request->query->getint('page', 1), 1);

        $datamotmaire = $motmaireRepository->findBy([], ['publishedAt' => 'DESC']);
        $motmaires = $paginator->paginate($datamotmaire, $request->query->getint('page', 1), 1);

        $datasliders = $sliderRepository->findBy([], ['publishedAt' => 'DESC']);
        $sliders = $paginator->paginate($datasliders, $request->query->getint('page', 1), 4);

        return $this->render('home/index.html.twig', [
            'articlesRece' => $articlesRece,
            'articles' => $articles,
            'sliders' => $sliders,
            'motmaires' => $motmaires,
            'coins' => $coinRepository->findAll(),
            'flashes' => $flashes,
            'videos' => $videoRepository->findAll(),
        ]);
    }

    #[Route('/Commune', name: 'commune_index', methods: ['GET', 'POST'])]
    public function commune(): Response
    {

        return $this->render('commune/commune_index.html.twig');
    }

    #[Route('/Activités-économie', name: 'activites_index', methods: ['GET', 'POST'])]
    public function activites(): Response
    {

        return $this->render('activite/activites_index.html.twig');
    }

    #[Route('/Commune-image', name: 'commune_image', methods: ['GET', 'POST'])]
    public function communeI(): Response
    {

        return $this->render('commune/commune_image.html.twig');
    }

    #[Route('/contact-nouveau', name: 'contact_nouveau', methods: ['GET', 'POST'])]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new TemplatedEmail())
                ->from($form->get('email')->getData())
                ->to($form->get('service')->getData()->getEmail())
                ->subject('contact au niveau du "' . $form->get('service')->getData()->getName() . '"')
                ->htmlTemplate('emails/contact.html.twig')
                ->context([
                    'contac' => $form,
                    'service' => $form->get('service')->getData()->getName(),
                    'mail' => $form->get('email')->getData(),
                    'objet' => $form->get('objet')->getData(),
                    'name' => $form->get('name')->getData(),
                    'message' => $form->get('message')->getData(),
                ]);
            $mailer->send($email);
            $entityManager = $this->getDoctrine()->getManager();
            $data = $form->get('service')->getData();
            $entityManager->persist($contact);
            $entityManager->flush();
            $this->addFlash('success', ' Merci d\'avoir contacter le ' . $data);
            return $this->redirectToRoute('contact_nouveau');
        }

        return $this->render('contact/contact.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/boite-nouveau', name: 'boitesuggestion_nouveau', methods: ['GET', 'POST'])]
    public function boite(Request $request): Response
    {
        $boitesuggestion = new Boitesuggestion();
        $form = $this->createForm(BoitesuggestionType::class, $boitesuggestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($boitesuggestion);
            $entityManager->flush();
            $this->addFlash('success', ' votre message nous est bien parvenu.');
            return $this->redirectToRoute('boitesuggestion_nouveau');
        }

        return $this->render('boitesuggestion/boitesuggestion.html.twig', [
            'boitesuggestion' => $boitesuggestion,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/Information-service', name: 'information_service', methods: ['GET', 'POST'])]
    public function info(): Response
    {

        return $this->render('information_service/information_service.html.twig');
    }

    #[Route('/Sport', name: 'sport_index', methods: ['GET', 'POST'])]
    public function sport(
        SportRepository $sportRepository,
        ImageSportRepository $imageSportRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $data = $sportRepository->findBy([], ['publishedAt' => 'DESC']);
        $sports = $paginator->paginate($data, $request->query->getint('page', 1), 1);

        $data = $imageSportRepository->findBy([], ['publishedAt' => 'DESC']);
        $image_sports = $paginator->paginate($data, $request->query->getint('page', 1), 6);

        return $this->render('sport/sport_index.html.twig', [
            'sports' => $sports,
            'image_sports' => $image_sports,
        ]);
    }

    #[Route('/Hotel', name: 'hotel_index', methods: ['GET', 'POST'])]
    public function hotel(
        HotelRestaurantRepository $hotelRestaurantRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $data = $hotelRestaurantRepository->findBy([], ['publishedAt' => 'DESC']);
        $hotel_restaurants = $paginator->paginate($data, $request->query->getint('page', 1), 6);

        return $this->render('hotel/hotel_index.html.twig', [
            'hotel_restaurants' => $hotel_restaurants,
        ]);
    }
}
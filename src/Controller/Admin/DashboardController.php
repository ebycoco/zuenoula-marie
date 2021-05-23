<?php

namespace App\Controller\Admin;

use App\Entity\AdministrationDeMunicipalite;
use App\Entity\Article;
use App\Entity\Boitesuggestion;
use App\Entity\Coin;
use App\Entity\Contact;
use App\Entity\Flash;
use App\Entity\FonctionnementMunicipale;
use App\Entity\GrandeSurface;
use App\Entity\HotelRestaurant;
use App\Entity\ImageSport;
use App\Entity\Maire;
use App\Entity\Motmaire;
use App\Entity\OrganeDeFonctionnement;
use App\Entity\PresentationMairie;
use App\Entity\Service;
use App\Entity\Slider;
use App\Entity\Sport;
use App\Entity\User;
use App\Entity\Video;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Mairie Zuenoula Officiel');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::subMenu('Accueil du site', 'fa fa-home')->setSubItems([
            MenuItem::linkToCrud('Article', 'fa fa-file-text', Article::class),
            // ->setPermission('ROLE_EDITOR'),
            MenuItem::linkToCrud('Image la une', 'fas fa-fa fa-image', Slider::class),
            MenuItem::linkToCrud('message info', 'fas fa-newspaper', Flash::class),
            MenuItem::linkToCrud('Vidéo', 'fas fa-newspaper', Video::class),
            MenuItem::linkToCrud('Mot du maire', 'fas fa-newspaper', Motmaire::class),
        ]);
        yield MenuItem::subMenu('Presentation', 'fas fa-newspaper')->setSubItems([
            MenuItem::linkToCrud('Presentation', 'fa fa-file-text', PresentationMairie::class),
            MenuItem::linkToCrud('Les maires', 'fas fa-fa fa-image', Maire::class),
            MenuItem::linkToCrud('Organe fonctionnement', 'fas fa-newspaper', OrganeDeFonctionnement::class),
            MenuItem::linkToCrud('Municipalité', 'fas fa-newspaper', FonctionnementMunicipale::class),
            MenuItem::linkToCrud('Administration Municipalité', 'fas fa-newspaper', AdministrationDeMunicipalite::class),
        ]);
        yield MenuItem::subMenu('ATOUTS', 'fas fa-newspaper')->setSubItems([
            MenuItem::linkToCrud('Sport', 'fa fa-file-text', Sport::class),
            MenuItem::linkToCrud('Image des sport', 'fas fa-newspaper', ImageSport::class),
            MenuItem::linkToCrud('Hotel restaurant', 'fas fa-fa fa-image', HotelRestaurant::class),
            MenuItem::linkToCrud('Grande surface', 'fas fa-newspaper', GrandeSurface::class),
        ]);
        yield MenuItem::linkToCrud('Coin du bonheur', 'fas fa-newspaper', Coin::class);
        yield MenuItem::linkToCrud('Contact', 'fas fa-newspaper', Contact::class);
        yield MenuItem::linkToCrud('Boite de suggestion', 'fas fa-newspaper', Boitesuggestion::class);
        yield MenuItem::linkToCrud('Video', 'fas fa-newspaper', Video::class);
        yield MenuItem::linkToCrud('Service de la mairie', 'fas fa-newspaper', Service::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', User::class);
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->setName($user->getUsername())
            ->setGravatarEmail($user->getUsername())
            ->displayUserAvatar($user->getUsername());
    }
}
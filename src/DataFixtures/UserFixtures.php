<?php

namespace App\DataFixtures;

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
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * Undocumented function
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($nbUsers = 1; $nbUsers <= 1; $nbUsers++) {
            $user = new User();
            if ($nbUsers === 1) {
                $user->setEmail("brouyaoeric7@gmail.com");
                $user->setRoles(['ROLE_ADMIN']);
                $user->setIsVerified(1);
                $user->setIsValide(1);
                $user->setPseudo("Ebychoco");
            }
            $user->setPassword($this->userPasswordEncoder->encodePassword($user, "123456"));
            $manager->persist($user);
        }
        for ($i = 1; $i <= 30; $i++) {
            $article = new Article();
            $article->setTitre($faker->sentence());
            $article->setUser($user);
            $article->setSlug($faker->realText(50));
            $article->setContenue($faker->text());
            $article->setActive($faker->numberBetween(0, 1));
            $article->setImageName($faker->imageUrl());
            $manager->persist($article);
        }
        for ($b = 1; $b <= 30; $b++) {
            $boitesuggestion = new Boitesuggestion();
            $boitesuggestion->setNom($faker->name());
            $boitesuggestion->setEmail($faker->email);
            $boitesuggestion->setMessage($faker->text());
            $manager->persist($boitesuggestion);
        }
        for ($c = 1; $c <= 3; $c++) {
            $coin = new Coin();
            $coin->setDescription($faker->realText(50));
            $coin->setTitre($faker->sentence());
            $coin->setImageName($faker->imageUrl());
            $coin->setUser($user);
            $manager->persist($coin);
        }
        for ($f = 1; $f <= 3; $f++) {
            $flash = new Flash();
            $flash->setContenue($faker->realText(50));
            $flash->setUser($user);
            $manager->persist($flash);
        }
        for ($ad = 1; $ad <= 3; $ad++) {
            $administrationDeMunicipalite = new AdministrationDeMunicipalite();
            $administrationDeMunicipalite->setTitre($faker->sentence());
            $administrationDeMunicipalite->setContenue($faker->realText(50));
            $administrationDeMunicipalite->setUser($user);
            $manager->persist($administrationDeMunicipalite);
        }
        for ($fm = 1; $fm <= 3; $fm++) {
            $fonctionnementMunicipale = new FonctionnementMunicipale();
            $fonctionnementMunicipale->setTitre($faker->sentence());
            $fonctionnementMunicipale->setContenue($faker->realText(50));
            $fonctionnementMunicipale->setUser($user);
            $manager->persist($fonctionnementMunicipale);
        }
        for ($gs = 1; $gs <= 16; $gs++) {
            $grandeSurface = new GrandeSurface();
            $grandeSurface->setTitre($faker->sentence());
            $grandeSurface->setDescription($faker->realText(50));
            $grandeSurface->setImageName($faker->imageUrl());
            $grandeSurface->setUser($user);
            $manager->persist($grandeSurface);
        }
        for ($hr = 1; $hr <= 16; $hr++) {
            $hotelRestaurant = new HotelRestaurant();
            $hotelRestaurant->setTitre($faker->sentence());
            $hotelRestaurant->setDescription($faker->realText(50));
            $hotelRestaurant->setImageName($faker->imageUrl());
            $hotelRestaurant->setUser($user);
            $manager->persist($hotelRestaurant);
        }
        for ($is = 1; $is <= 16; $is++) {
            $image_sport = new ImageSport();
            $image_sport->setImageName($faker->imageUrl());
            $image_sport->setUser($user);
            $manager->persist($image_sport);
        }
        for ($ma = 1; $ma <= 6; $ma++) {
            $maire = new Maire();
            $maire->setNomPrenom($faker->name());
            $maire->setProffesion($faker->sentence());

            if ($ma == 6) {
                $maire->setDebutFonction($faker->dateTimeBetween('-6 month', 'now'));
                $maire->setIsActive(true);
            } else {
                $maire->setDebutFonction($faker->dateTimeBetween('-6 month', 'now'));
                $maire->setFinFonction($faker->dateTimeBetween('-6 month', 'now'));
                $maire->setIsActive(false);
            }



            $maire->setImageName($faker->imageUrl());
            $maire->setUser($user);
            $manager->persist($maire);
        }
        for ($mta = 1; $mta <= 6; $mta++) {
            $motmaire = new Motmaire();
            $motmaire->setNom($faker->name());
            $motmaire->setContenue($faker->text());
            $motmaire->setImageName($faker->imageUrl());
            $motmaire->setUser($user);
            $manager->persist($motmaire);
        }
        for ($og = 1; $og <= 6; $og++) {
            $organeDeFonctionnement = new OrganeDeFonctionnement();
            $organeDeFonctionnement->setTitre($faker->sentence());
            $organeDeFonctionnement->setContenue($faker->text());
            if ($og == 1) {
                $organeDeFonctionnement->setImageName($faker->imageUrl());
            }
            $organeDeFonctionnement->setUser($user);
            $manager->persist($organeDeFonctionnement);
        }

        for ($p = 1; $p <= 6; $p++) {
            $presentationMairy = new PresentationMairie();
            $presentationMairy->setTitre($faker->sentence());
            $presentationMairy->setContenue($faker->text());
            $presentationMairy->setUser($user);
            $manager->persist($presentationMairy);
        }
        for ($s = 1; $s <= 6; $s++) {
            $service = new Service();
            $service->setName($faker->name());
            $service->setEmail($faker->email);
            $service->setUser($user);
            $manager->persist($service);
        }
        for ($sl = 1; $sl <= 16; $sl++) {
            $slider = new Slider();
            $slider->setTitre($faker->sentence());
            $slider->setDescription($faker->realText(50));
            $slider->setImageName($faker->imageUrl());
            $slider->setUser($user);
            $manager->persist($slider);
        }
        for ($sp = 1; $sp <= 16; $sp++) {
            $sport = new Sport();
            $sport->setContenue($faker->text());
            $sport->setUser($user);
            $manager->persist($sport);
        }
        for ($v = 1; $v <= 16; $v++) {
            $video = new Video();
            $video->setLien($faker->word(4, true));
            $video->setTitre($faker->sentence());
            $video->setDescription($faker->word(10, true));
            $video->setUser($user);
            $manager->persist($video);
        }
        $manager->flush();
    }
}
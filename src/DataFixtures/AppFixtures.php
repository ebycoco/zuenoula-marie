<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $faker = Faker\Factory::create('fr_FR');
        // for ($i = 1; $i <= 30; $i++) {
        //     $user = $this->getReference('user_' . $faker->numberBetween(1, 1));

        //     $article = new Article();
        //     $article->setTitre($faker->sentence());
        //     $article->setUser($user);
        //     $article->setSlug($faker->realText(50));
        //     $article->setContenue($faker->text());
        //     $article->setActive($faker->numberBetween(0, 1));
        //     $article->setImageFile('acc.jpg');
        //     $manager->persist($article);
        // }

        $manager->flush();
    }
}